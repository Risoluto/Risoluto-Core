#!/bin/bash
################################################################################################
# This file is part of Risoluto( http://www.risoluto.org/ )                                    #
# Risoluto is released under New BSD License( http://opensource.org/licenses/bsd-license.php ) #
# (C) 2008-2014 Risoluto Developers / All Rights Reserved.                                     #
################################################################################################
./vendor/bin/phpunit --bootstrap=./phpunit_bootstrap.php --configuration=./phpunit.xml
