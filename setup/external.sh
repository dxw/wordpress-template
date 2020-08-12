#!/bin/sh
set -e

##
## This code will be run during setup, OUTSIDE the container.
##
## Because `whippet` running inside the container wouldn't be able to connect
## to private repositories.
##

if test -f whippet.json; then
  whippet deps install
fi
