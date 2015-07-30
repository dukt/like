#!/bin/bash

for VERSION in "$@"

do

# Create Info.php with plugin version constant

cat > Source/${PLUGIN_NAME}/Info.php << EOF
<?php

namespace Craft;

define('${PLUGIN_NAME_UP}_VERSION', '$VERSION');

EOF

done
