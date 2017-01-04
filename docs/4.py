import pymysql
import sys
import datetime

if __name__ == "__main__":

    _host = 'localhost'
    _user = 'root'
    _password = ''
    _databse = 'atk'

    def getAllData(table, cursor) :
        sql = "SELECT * FROM %s;" %(table)
        cursor.execute(sql)
        return cursor.fetchall()

    def insertData(cursor, lesson_id, ldate, updated_by, created_at, updated_at) :
        sql = "INSERT INTO lesson_date \
                      (lesson_id, ldate, updated_by, created_at, updated_at)\
                      VALUES (%s, '%s', %s, '%s', '%s'); " %\
                      (lesson_id, ldate, updated_by, created_at, updated_at)
        cursor.execute(sql)
    
    def batch() :
        print ('Start')
        connection = pymysql.connect(host=_host,
                                     user=_user,
                                     password=_password,
                                     database=_databse)
        cursor = connection.cursor()
        
        list_lesson = getAllData('lesson', cursor)
        list_semester_date = getAllData('semester_date', cursor)
        list_lesson_date = getAllData('lesson_date', cursor)

        list_ldate = []
        for a in list_lesson_date :
            list_ldate.append(a[2])
        
        list_ldate = list(set(list_ldate))
##        print (list_ldate)

        for a in list_semester_date :
            weekday = a[4] + 1
            ldate = a[2]
            if (a[5] == 0) :
                if (ldate not in list_ldate) : 
                    for b in list_lesson :
                        l_weekday = int(b[9])
                        
                        if weekday == l_weekday:
                            
                            lesson_id = b[0]
                            ldate = a[2]
                            updated_by = 2;
                            created_at = datetime.datetime.now()
                            updated_at = created_at
                            insertData(cursor, lesson_id, ldate, updated_by, created_at, updated_at)
        
        cursor = connection.cursor()
        cursor.close()
        connection.commit()
        connection.close()
        print ('Done!')
    batch()
