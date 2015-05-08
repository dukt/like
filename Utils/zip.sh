#!/bin/bash

export SOURCE_FOLDER="Source/"
export BUILD_FOLDER="Build/"
export ZIP_FOLDER="Zip/"
export BUILD_PLUGIN_FOLDER="${BUILD_FOLDER}/${PLUGIN_NAME}/"
export PLUGIN_NAME_WITH_VERSION="${PLUGIN_NAME}-${PLUGIN_VERSION}.${BUILD_NUMBER}"

# Copy Build

rm -rf $BUILD_FOLDER
mkdir $BUILD_FOLDER
cp -R $SOURCE_FOLDER $BUILD_PLUGIN_FOLDER

# Clean up Build/

find ./$BUILD_PLUGIN_FOLDER -name ".git" -exec rm -rf {} \;
rm ./$BUILD_PLUGIN_FOLDER/composer.json
rm ./$BUILD_PLUGIN_FOLDER/composer.lock

# zip

rm -rf $ZIP_FOLDER
mkdir $ZIP_FOLDER

# Copy build to zip folder and give its final name
cp -R $BUILD_PLUGIN_FOLDER $ZIP_FOLDER$PLUGIN_NAME_WITH_VERSION

cd $ZIP_FOLDER
zip -r "${PLUGIN_NAME_WITH_VERSION}.zip" $PLUGIN_NAME_WITH_VERSION
rm -rf $PLUGIN_NAME_WITH_VERSION
cd ../
