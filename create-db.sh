#!/bin/bash

set -x

# DB Init (this would usually be in done in a better way)

HAS_DB_RESULT=$(mysql --user=root --password=awesome_password -B -N --execute="SHOW DATABASES LIKE 'onecall_test';")

if [ "onecall_test" != "$HAS_DB_RESULT" ]
then
    mysql --user=root --password=awesome_password --execute="CREATE DATABASE onecall_test;" > /dev/null

    read -r -d '' CAR_TABLE_CREATE << EOM
CREATE TABLE onecall_test.Car(
    carId        int unsigned auto_increment,
    registration varchar(10) NOT NULL,
    make         varchar(20) NOT NULL,
    model        varchar(20) NOT NULL,

    PRIMARY KEY(carId)
)
ENGINE=InnoDB,
DEFAULT CHARSET=utf8,
COMMENT='Car table';
EOM

    mysql --user=root --password=awesome_password --execute="$CAR_TABLE_CREATE" > /dev/null

    read -r -d '' CUSTOMER_TABLE_CREATE << EOM
CREATE TABLE onecall_test.Customer(
    customerId        int unsigned auto_increment,
    carId             int unsigned NOT NULL,
    name              varchar(50) NOT NULL,
    dob               date NOT NULL,
    licenseNumber     varchar(30) NOT NULL,

    PRIMARY KEY(customerId),
    FOREIGN KEY(carId) REFERENCES onecall_test.Car(carId)
)
ENGINE=InnoDB,
DEFAULT CHARSET=utf8,
COMMENT='Customer table';
EOM
    mysql --user=root --password=awesome_password --execute="$CUSTOMER_TABLE_CREATE" > /dev/null

    read -r -d '' ADDRESS_TABLE_CREATE << EOM
CREATE TABLE onecall_test.CustomerAddress(
    customerId int unsigned,
    line1      varchar(50) NOT NULL,
    line2      varchar(50) NOT NULL,
    town       varchar(50) NOT NULL,
    postcode   varchar(20) NOT NULL,

    PRIMARY KEY(customerId),
    FOREIGN KEY(customerId) REFERENCES onecall_test.Customer(customerId)
)
ENGINE=InnoDB,
DEFAULT CHARSET=utf8,
COMMENT='Customer address table';
EOM
    mysql --user=root --password=awesome_password --execute="$ADDRESS_TABLE_CREATE" > /dev/null

    read -r -d '' QUOTE_TABLE_CREATE << EOM
CREATE TABLE onecall_test.Quote(
    quoteId           int unsigned auto_increment,
    carId             int unsigned,
    premium           decimal(8.2) NOT NULL,
    additionalPremium decimal(8,2) NOT NULL,
    createDate        DATETIME NOT NULL,

    PRIMARY KEY(quoteId),
    FOREIGN KEY(carId) REFERENCES onecall_test.Car(carId)
)
ENGINE=InnoDB,
DEFAULT CHARSET=utf8,
COMMENT='Quote table';
EOM
    mysql --user=root --password=awesome_password --execute="$QUOTE_TABLE_CREATE" > /dev/null
fi


