#!/bin/bash

for VERSION in "$@"

do

    export SOURCE_FOLDER="Source/"
    export BUILD_FOLDER="Build/"
    export ZIP_FOLDER="Zip/"
    export BUILD_PLUGIN_FOLDER="${BUILD_FOLDER}/${PLUGIN_NAME}/"
    export PLUGIN_NAME_WITH_VERSION="${PLUGIN_NAME}-${VERSION}"

    # Copy Build

    rm -rf $BUILD_FOLDER
    mkdir $BUILD_FOLDER
    cp -R $SOURCE_FOLDER $BUILD_PLUGIN_FOLDER


    # Clean up Build/

    find ./$BUILD_PLUGIN_FOLDER -name ".git" -exec rm -rf {} \;
    rm ./$BUILD_PLUGIN_FOLDER/composer.json
    rm ./$BUILD_PLUGIN_FOLDER/composer.lock
    rm ./$BUILD_PLUGIN_FOLDER/gulpfile.js
    rm ./$BUILD_PLUGIN_FOLDER/package.json

    # zip

    rm -rf $ZIP_FOLDER
    mkdir $ZIP_FOLDER

    # Copy build to zip folder and give its final name
    cp -R $BUILD_PLUGIN_FOLDER "${ZIP_FOLDER}craft-${PLUGIN_NAME_WITH_VERSION}"

    cd $ZIP_FOLDER
    zip -r "craft-${PLUGIN_NAME_WITH_VERSION}.zip" "craft-${PLUGIN_NAME_WITH_VERSION}"
    rm -rf "craft-${PLUGIN_NAME_WITH_VERSION}"

    ls -la

    cd ../


    # Create git tag

    set -e

    if GIT_DIR=./.git git show-ref --tags | egrep -q "refs/tags/${VERSION}"

    then
        echo "Found tag ${VERSION}, don't create it"
    else
        echo "Tag ${VERSION} not found, create it"
        git tag ${VERSION}
        git push --tags
    fi

done
