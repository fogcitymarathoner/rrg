__author__ = 'marc'
import pymysql
import csv
from datetime import datetime as dt
import os
from tenjin.helpers import *
conn = pymysql.connect(host='127.0.0.1', port=3306, user='marc_dba', passwd='flaming', db='rrgprod')
cur = conn.cursor()


DATE = 0
AMOUNT = 1
DESCRIPTION = 2
NOTES = 3

with open('autoexp.csv', 'r') as csvfile_saved:
    reader = csv.reader(csvfile_saved, delimiter=',', quotechar='"')
    count = 0
    for row in reader:

        if count > 0:
            # skip Header

            q = "insert into expenses (amount, category_id, employee_id, description, notes, date, created_user_id, modified_user_id, created_date, modified_date) values ('%s', 2, 1479, '%s', '%s', '%s', '%s', '%s', '%s', '%s')"%(row[AMOUNT], row[DESCRIPTION], row[NOTES], row[DATE], 2, 2, dt.now(), dt.now())
            print(q)
            cur.execute(q)

        else:
            count += 1
            continue
        count += 1


cur.close()
conn.close()