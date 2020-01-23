#!/bin/bash

########################
# Generate Certificate #
########################

certsDir=./certs
certsConfDir=./certs_conf
secretsDir=./secrets

C=FR
ST=Ile-de-france
L=Paris
O=Dev
CN=*.localhost

success() {
    echo -e "\033[32m ✔ Success\n"
}

message() {
    echo -e "\033[90m $1"
}

generateRootKey() {
    message "1 - Generating the root key..."

    openssl genrsa -out "$certsDir/root-ca.key" 4096
    
    success
}

generateCSR() {
    message "2 - Generating a CSR using the root key..."
    
    openssl req \
        -new -key "$certsDir/root-ca.key" \
        -out "$certsDir/root-ca.csr" -sha256 \
        -subj '/C='$C'/ST='$ST'/L='$L'/O='$O'/CN='$CN''
    
    success
}

signCertificate() {
    message "3 - Signing the certificate..."
    
    openssl x509 -req -days 3650 -in "$certsDir/root-ca.csr" \
        -signkey "$certsDir/root-ca.key" -sha256 -out "$certsDir/root-ca.crt" \
        -extfile "$certsConfDir/root-ca.cnf" -extensions \
        root_ca
    
    success
}

generateSiteKey() {
    message "4 - Generating the site key..."
    
    openssl genrsa -out "$secretsDir/site.key" 4096
    
    success
}

generateSiteCertification() {
    message "5 - Generating the site certificate and sign it with the site key."
    
    openssl req -new -key "$secretsDir/site.key" -out "$certsDir/site.csr" -sha256 \
        -subj '/C='$C'/ST='$ST'/L='$L'/O='$O'/CN='$CN''
    
    success
}

signSiteCertificate() {
    message "6 - Signing the site certificate."
    
    openssl x509 -req -days 750 -in "$certsDir/site.csr" -sha256 \
        -CA "$certsDir/root-ca.crt" -CAkey "$certsDir/root-ca.key" -CAcreateserial \
        -out "$secretsDir/site.crt" -extfile "$certsConfDir/site.cnf" -extensions server
    
    success
}

generateCerts() {
    echo -e "\n\033[35m==========  Generating HTTPS Certificates  ==========\n\033[37m"

    if [ ! -d $certsDir ]; then
        mkdir $certsDir
    fi

    if [ ! -d $secretsDir ]; then
        mkdir $secretsDir
    fi

    generateRootKey
    generateCSR
    signCertificate
    
    generateSiteKey
    generateSiteCertification
    signSiteCertificate
}

execute() {
    if [ -f $secretsDir/sites.crt -a -f $secretsDir/site.key ]; then
        echo -e "\033[32m HTTPS environment already configured\n"
    else
        generateCerts
    fi
}

execute
