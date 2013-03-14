#!/bin/bash

#==============================================================================
# @package   risoluto
# @author    Risoluto Developers
# @license   http://opensource.org/licenses/bsd-license.php new BSD license
# @copyright (C) 2008-2013 Risoluto Developers / All Rights Reserved.
#==============================================================================

# Settings
SMARTY_VER="stable"
SMARTY_VER_ALT="3.0.9"
PHP_VER="5.2.3"
PEAR_VER="1.8.0"


# Tests
echo "Check environment...."
RMCMD=`which rm 2>/dev/null`
if [ "x${RMCMD}" == "x" ];
then
  echo "Error: rm is not found."
  exit 1
fi

MVCMD=`which mv 2>/dev/null`
if [ "x${MVCMD}" == "x" ];
then
  echo "Error: mv is not found."
  exit 1
fi

TARCMD=`which tar 2>/dev/null`
if [ "x${TARCMD}" == "x" ];
then
  echo "Error: tar is not found."
  exit 1
fi

WGETCMD=`which wget 2>/dev/null`
if [ "x${WGETCMD}" == "x" ];
then
  echo "Error: wget is not found."
  exit 1
fi

PHPCMD=`which php 2>/dev/null`
if [ "x${PHPCMD}" == "x" ];
then
  echo "Error: php is not found."
  exit 1
else
  PHP_INSTALLED=`${PHPCMD} --version 2>&1 |grep "built"|awk '{print $2;}'`
  if [ `echo ${PHP_INSTALLED}|sed "s/\.//g"` -lt `echo ${PHP_VER}|sed "s/\.//g"` ];
  then
    echo "Notice: php version is too old to use Smarty-3.1.x. Install Smarty-3.0.x."
    SMARTY_VER="${SMARTY_VER_ALT}"
  fi
fi

PEARCMD=`which pear 2>/dev/null`
if [ "x${PEARCMD}" == "x" ];
then
  echo "Error: pear is not found."
  exit 1
else
  PEAR_INSTALLED=`${PEARCMD} version 2>&1 |grep "PEAR Version:"|sed "s/PEAR Version: //g"`
  if [ `echo ${PEAR_INSTALLED}|sed "s/\.//g"` -lt `echo ${PEAR_VER}|sed "s/\.//g"` ];
  then
    echo "Error: pear version is too old. Try '${PEARCMD} upgrade PEAR'."
    echo "[Note]If you failed, try '${PEARCMD} upgrade --force PEAR ; ${PEARCMD} upgrade-all'."
    exit 1
  fi
fi

# Delete current directories/files
echo "Cleanning...."
${RMCMD} -fr ./extlib_setup.log
${RMCMD} -fr ./.pearrc
${RMCMD} -fr ./PEAR
${RMCMD} -fr ./Smarty
${RMCMD} -fr ./pear

# Install pear
echo "Install pear...."
${PEARCMD} config-create `pwd` ./.pearrc 2>&1 >>./extlib_setup.log
${PEARCMD} -c ./.pearrc config-set php_dir `pwd`/PEAR/ 2>&1 >>./extlib_setup.log
${PEARCMD} -c ./.pearrc channel-update pear.php.net 2>&1 >>./extlib_setup.log
${PEARCMD} -c ./.pearrc install --alldeps -o PEAR 2>&1 >>./extlib_setup.log
${PEARCMD} -c ./.pearrc install --alldeps -o MDB2 2>&1 >>./extlib_setup.log
${PEARCMD} -c ./.pearrc install --alldeps -o MDB2_Driver_mysqli 2>&1 >>./extlib_setup.log
${PEARCMD} -c ./.pearrc install --alldeps -o MDB2_Driver_mysql 2>&1 >>./extlib_setup.log
${PEARCMD} -c ./.pearrc install --alldeps -o Pager 2>&1 >>./extlib_setup.log

# Install Smarty
echo "Install Smarty...."
${WGETCMD} -a ./extlib_setup.log "http://www.smarty.net/files/Smarty-${SMARTY_VER}.tar.gz"
${TARCMD} xvzf ./Smarty-*.tar.gz 2>&1 >>./extlib_setup.log
${RMCMD} -fr ./Smarty-*.tar.gz 2>&1 >>./extlib_setup.log
${MVCMD} ./Smarty-*/ ./Smarty 2>&1 >>./extlib_setup.log

echo "Done. If you have problems, check extlib_setup.log."
