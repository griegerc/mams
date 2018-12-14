#!/bin/bash

# Define a timestamp function
timestamp() {
    date +%s
}

BACKUP_FILE=/home/[USERNAME]/mams/backup_$(timestamp).sql

mysqldump mams > ${BACKUP_FILE}
gzip ${BACKUP_FILE}
