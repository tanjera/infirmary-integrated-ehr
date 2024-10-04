#!/bin/bash

# ####
# Color Constants
# ####

# Reset
Reset='\033[0m'           # Text Reset
# Regular Colors
Black='\033[0;30m'        # Black
Red='\033[0;31m'          # Red
Green='\033[0;32m'        # Green
Yellow='\033[0;33m'       # Yellow
Blue='\033[0;34m'         # Blue
Purple='\033[0;35m'       # Purple
Cyan='\033[0;36m'         # Cyan
White='\033[0;37m'        # White
# Bold
BBlack='\033[1;30m'       # Black
BRed='\033[1;31m'         # Red
BGreen='\033[1;32m'       # Green
BYellow='\033[1;33m'      # Yellow
BBlue='\033[1;34m'        # Blue
BPurple='\033[1;35m'      # Purple
BCyan='\033[1;36m'        # Cyan
BWhite='\033[1;37m'       # White


# ####
# General Constants
# ####

SCRIPT_PATH=$( pwd )
cd ..
SOLUTION_PATH=$( pwd )

OUT_PREFIX="\n${BCyan}>>>>>${Reset} "

# Location of published executable files in the build structure
RELEASE_PATH="$SOLUTION_PATH/release"

# Location of package information templates (for .deb, .rpm, .app)
PACKAGE_FS="$SOLUTION_PATH/package/linux/_filesystem"
DEB_DIR="$SOLUTION_PATH/package/linux/DEB"

# ####
# Error checking before beginning script
# ####

if ! command -v uuidgen &> /dev/null; then
    echo "Error: uuidgen could not be found"
    echo "Please install package uuid-runtime"
    exit
fi

if ! command -v dpkg-deb &> /dev/null; then
    echo "Error: dpkg-deb could not be found"
    echo "Please install package"
    exit
fi

# ####
# Set up directories to use, gather user information
# ####

mkdir -p "$RELEASE_PATH"

echo -ne "${OUT_PREFIX}What version number should this build use? "
read VERSION

# Setup working (/tmp) directory and subdirectories
UUID=$(uuidgen)
DIR_WORKING="/tmp/$UUID"

echo -e "${OUT_PREFIX}Creating working directory $DIR_WORKING"

# Move the published projects to the temporary directories
echo -e "${OUT_PREFIX}Copying project files to working directory"
mkdir -p "${DIR_WORKING}/infirmary-integrated-ehr"

cp -r "${SOLUTION_PATH}/base/app" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/artisan" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/bootstrap" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/composer.json" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/composer.lock" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/config" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/database" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/.env.example" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/package.json" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/package-lock.json" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/public" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/resources" "${DIR_WORKING}/infirmary-integrated-ehr"
cp -r "${SOLUTION_PATH}/base/routes" "${DIR_WORKING}/infirmary-integrated-ehr"

# ####
# Package the project
# ####

PACK_NAME="infirmary-integrated-ehr-${VERSION}-all"

PACK_PATH="${SOLUTION_PATH}/release/${PACK_NAME}.tar.gz"
if [ -f "${PACK_PATH}" ]; then            
    rm "${PACK_PATH}"
fi

echo -e "${OUT_PREFIX}Packaging into ${RELEASE_PATH}/${PACK_NAME}.tar.gz"
cd "${DIR_WORKING}"
tar -czf "${RELEASE_PATH}/${PACK_NAME}.tar.gz" "infirmary-integrated-ehr"

# ####
# Package into .deb
# ####

DEB_PACKAGE="infirmary-integrated-ehr_${VERSION}_all.deb"

echo -e "${OUT_PREFIX}Creating .deb file structure"
DEB_FS="$DIR_WORKING/infirmary-integrated-ehr"
mv "$DIR_WORKING/infirmary-integrated-ehr" "$DIR_WORKING/base"
mkdir "$DEB_FS"

cp -R "$DEB_DIR/"* "$DEB_FS"
cp -R "$PACKAGE_FS/"* "$DEB_FS"
printf "Version: %s\n" $VERSION >> "$DEB_FS/DEBIAN/control"
cp -rT "$DIR_WORKING/base" "$DEB_FS/var/www/infirmary-integrated-ehr"

echo -e "${OUT_PREFIX}Packing .deb package\n"
dpkg-deb --build "$DEB_FS" >> /dev/null

echo -e "Moving .deb package to $RELEASE_PATH/$DEB_PACKAGE\n"
mv -f "$DIR_WORKING/infirmary-integrated-ehr.deb" "$RELEASE_PATH/$DEB_PACKAGE"        

rm -r "${DIR_WORKING}"

# ####
# Create SHA512 checksums and sign the hash list
# ####

cd "${RELEASE_PATH}"
rm sha512sums
rm sha512sums.sig
sha512sum *.rpm >> "${RELEASE_PATH}/sha512sums"
sha512sum *.deb >> "${RELEASE_PATH}/sha512sums"
sha512sum *.tar.gz >> "${RELEASE_PATH}/sha512sums"
gpg --detach-sign sha512sums
