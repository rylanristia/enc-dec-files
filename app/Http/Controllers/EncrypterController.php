<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class EncrypterController extends Controller
{
    public function encrypter(Request $request)
    {
        return view('pages.encrypter');
    }

    public function symmetricEncrypt(Request $request)
    {
        $iv = openssl_random_pseudo_bytes(16);

        $file = $request->file('filetarget');
        $originalName = $file->getClientOriginalName();

        $fileContent = file_get_contents($file);

        $encryptedContent = openssl_encrypt($fileContent, $request->chiper, $request->key, OPENSSL_RAW_DATA, $iv);

        $finalEncryptedContent = $iv . $encryptedContent;

        $encryptedPath = 'encrypted/' . $originalName . '.enc'; // Menambahkan ekstensi .enc
        Storage::put($encryptedPath, $finalEncryptedContent);

        return back()->with('success', 'File uploaded and encrypted successfully!')
            ->with('encrypted_path', $encryptedPath);
    }

    public function asymmetricEncrypt(Request $request)
    {
        // Get the file to encrypt
        $file = $request->file('filetarget');
        $originalName = $file->getClientOriginalName();
        $fileContent = file_get_contents($file);

        // Get the RSA public key
        $key = $request->file('key');
        $publicKey = file_get_contents($key);

        // Generate AES key and IV
        $aesKey = openssl_random_pseudo_bytes(32); // 256-bit AES key
        $iv = openssl_random_pseudo_bytes(16);    // Initialization Vector (IV)

        // Encrypt the AES key using RSA
        $encryptedAesKey = '';

        openssl_public_encrypt($aesKey, $encryptedAesKey, $publicKey, OPENSSL_PKCS1_PADDING);

        if (!openssl_public_encrypt($aesKey, $encryptedAesKey, $publicKey, OPENSSL_PKCS1_PADDING)) {
            return back()->with('error', 'RSA public key encryption failed. Please verify your key.');
        }

        // Encrypt the file content using AES
        $encryptedFileContent = openssl_encrypt($fileContent, $request->chiper, $aesKey, OPENSSL_RAW_DATA, $iv);

        // Combine the encrypted AES key, IV, and encrypted file content
        $finalEncryptedData = $encryptedAesKey . $iv . $encryptedFileContent;

        // Save the encrypted file
        $encryptedPath = 'encrypted/' . $originalName . '.enc';
        Storage::put($encryptedPath, $finalEncryptedData);

        return back()->with('success', 'File uploaded and encrypted successfully!')
            ->with('encrypted_path', $encryptedPath);
    }

}