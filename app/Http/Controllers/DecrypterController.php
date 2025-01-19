<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class DecrypterController extends Controller
{
    public function decrypter(Request $request)
    {
        return view('pages.decrypter');
    }

    public function symmetricDecrypter(Request $request)
    {
        $file = $request->file('filetarget');
        $originalName = $file->getClientOriginalName();

        $fileContent = file_get_contents($file);

        $iv = substr($fileContent, 0, 16);
        $encryptedData = substr($fileContent, 16);

        $decryptedContent = openssl_decrypt($encryptedData, $request->chiper, $request->key, OPENSSL_RAW_DATA, $iv);

        if ($decryptedContent === false) {
            return back()->with('error', 'Decryption failed!');
        }

        $decryptedPath = 'decrypted/' . str_replace('.enc', '', $originalName);
        Storage::put($decryptedPath, $decryptedContent);

        return back()->with('success', 'File decrypted successfully!')
            ->with('decrypted_path', $decryptedPath);
    }

    public function asymmetricDecrypter(Request $request)
    {
        // Get the encrypted file
        $file = $request->file('filetarget');
        $originalName = $file->getClientOriginalName();
        $fileContent = file_get_contents($file);

        // Get the RSA private key
        $key = $request->file('key');
        $privateKey = file_get_contents($key);

        // Determine the RSA key size and extract the encrypted AES key
        $keyResource = openssl_pkey_get_private($privateKey);
        $keyDetails = openssl_pkey_get_details($keyResource);
        $rsaKeySize = $keyDetails['bits'] / 8; // Convert bits to bytes

        $encryptedAesKey = substr($fileContent, 0, $rsaKeySize); // RSA-encrypted AES key
        $iv = substr($fileContent, $rsaKeySize, 16);            // IV
        $encryptedFileContent = substr($fileContent, $rsaKeySize + 16); // AES-encrypted file content

        // Decrypt the AES key using RSA
        $aesKey = '';
        if (!openssl_private_decrypt($encryptedAesKey, $aesKey, $privateKey, OPENSSL_PKCS1_PADDING)) {
            return back()->with('error', 'RSA private key decryption failed. Please verify your key.');
        }

        // Decrypt the file content using AES
        $decryptedFileContent = openssl_decrypt($encryptedFileContent, $request->chiper, $aesKey, OPENSSL_RAW_DATA, $iv);

        // Save the decrypted file
        $decryptedPath = 'decrypted/' . str_replace('.enc', '', $originalName);
        Storage::put($decryptedPath, $decryptedFileContent);

        return back()->with('success', 'File uploaded and decrypted successfully!')
            ->with('decrypted_path', $decryptedPath);
    }
}