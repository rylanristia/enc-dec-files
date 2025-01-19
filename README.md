<strong>Instruction</strong>

to start the program, open the terminal in root folder project and run a few commands seperately

1. composer update
2. php artisan optimize
3. php artisan serve

now open the browser with url that append after command No. 3

<hr>
<hr>

for the asymetrical encryption. make sure you generate the pair key (public and private) before <br>
you can use command bellow to generate
Generating the Private Key -- Windows
In Windows:

// create the private key
openssl genrsa -out rsa.private 1024

// export the public key
openssl rsa -in rsa.private -out rsa.public -pubout -outform PEM

you can change the 1024 with the following bits
[1024, 2048, 4096, 8192]
