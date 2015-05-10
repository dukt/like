#!/bin/bash

for VERSION in "$@"

do

# Create Info.php with plugin version constant

cat > Source/like/Info.php << EOF
<?php

namespace Craft;

define('LIKE_VERSION', '$VERSION');

EOF

done
