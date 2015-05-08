#!/bin/bash

# Create Info.php with plugin version constant

cat > Source/$PLUGIN_NAME/Info.php << EOF
<?php

namespace Craft;

define('${PLUGIN_CONSTANT_PREFIX}_VERSION', '$PLUGIN_VERSION.$BUILD_NUMBER');

EOF
