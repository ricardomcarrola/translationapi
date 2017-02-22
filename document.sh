#!/bin/bash

phpdoc --ignore "vendor/*" -d "./" -t "./docs/" --template="clean"