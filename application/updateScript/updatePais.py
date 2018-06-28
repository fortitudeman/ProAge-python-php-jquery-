#!/usr/bin/python

import datetime
import MySQLdb
import MySQLdb.cursors

def calculatePai(amount, year):

    pai = 0
    if year == 2018 or year == 2017:
        if amount >= 12000 and amount < 110000:
            pai = 1
        elif amount >= 110000 and amount < 500000:
            pai = 2
        elif amount >= 500000:
            pai = 3
    elif year == 2016:
        if amount >= 12000 and amount < 100000:
            pai = 1
        elif amount >= 100000 and amount < 500000:
            pai = 2
        elif amount >= 500000:
            pai = 3
    elif year == 2015:
        if amount >= 10000 and amount < 100000:
            pai = 1
        elif amount >= 100000 and amount < 500000:
            pai = 2
        elif amount >= 500000:
            pai = 3
    else:
        if amount >= 10000:
            pai = 1
    return pai


db = MySQLdb.connect(host="proages-db.coroolzydzjr.us-east-1.rds.amazonaws.com", 
                     user="proages", 
                     passwd="sjme17dkrmtl0km5p", 
                     db="proages-dev", connect_timeout=10,
                     cursorclass=MySQLdb.cursors.DictCursor)
cur = db.cursor()
cursor = db.cursor()
sql = "SELECT * FROM payments WHERE year_prime = 1 and payment_date between '%s-%s-01' and LAST_DAY('%s-%s-01')"
update = "UPDATE payments SET pai_business = %s WHERE pay_tbl_id = %s"
updatePai = dict()
years = [2014, 2015, 2016, 2017,  2018]
months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
totalRows = 0
try:
    for year in years:
        print("Year: %s", year)
        for month in months:
            print ("Month: %s", month)
            values = (year, month, year, month)
            rows = cur.execute(sql, values)
            if  rows > 0:
                for row in cur:
                    cursor.execute("SELECT SUM(pai_business) as totalPai FROM payments WHERE policy_number = %s", row["policy_number"])
                    result_set = cursor.fetchall()
                    for second in result_set:
                        totalPai = second['totalPai']
                    if row['policy_number'] in updatePai:
                        updatePai[row['policy_number']]['id'] = row['pay_tbl_id']
                        updatePai[row['policy_number']]['amount'] += row['amount']
                        pai = calculatePai(
                            updatePai[row['policy_number']]['amount'], year) - totalPai
                    else:
                        updatePai = {row['policy_number']: {'amount': row['amount'], 'date': row['payment_date'], 'id': row['pay_tbl_id']}}
                        pai = calculatePai(row['amount'], year) - totalPai
                    if pai != 0:
                        valuesUpdate = (pai, updatePai[row['policy_number']]['id'])

                        cur.execute(update, valuesUpdate)
                        db.commit()
                        totalRows += 1
        print("Rows affected: %s", totalRows)
finally:
    cur.close()
    db.close()


