import pymysql
import sys
import datetime

if __name__ == "__main__":

    _host = 'localhost'
    _user = 'root'
    _password = ''
    _databse = 'atk'

    def getData(name, cursor) :
        sql = "SELECT * FROM %s;" %(name)
        cursor.execute(sql)
        return cursor.fetchall()

    def updateData(cursor, semester_id, tdate, week_num, weekday, is_holiday, created_at, updated_at) :
        sql = "INSERT INTO semester_date \
                     (`semester_id`, `tdate`, `week_num`, `weekday`, `is_holiday`, `created_at`, `updated_at`) \
                     VALUES (%s, '%s', %s, %s, %s, '%s', '%s')" %\
                     (semester_id, tdate, week_num, weekday, is_holiday, created_at, updated_at)
##        print (sql)
        cursor.execute(sql)
    
    def batch() :
        print ('Start')
        connection = pymysql.connect(host=_host,
                                     user=_user,
                                     password=_password,
                                     database=_databse)
        cursor = connection.cursor()
        
        public_holiday = getData('public_holiday', cursor)
        semester_date = getData('semester_date', cursor)
        semester_info = getData('semester_info', cursor)
        
        list_holiday = [];
        for a in public_holiday : 
            list_holiday.append(a[3])
      
        list_semester_id = []
        for a in semester_date :
            list_semester_id.append(a[1])

        list_semester_id = list(set(list_semester_id))
##        for a in list_semester_id : 
##            print (a)
        for a in semester_info :
            semester_id = a[0]
            if (semester_id not in list_semester_id) : 
                start_date = a[2]
                end_date = a[3]
                week_num = 0;
                while start_date <= end_date:
                    tdate = start_date;
                    weekday = tdate.isoweekday()
                    week_num += (weekday == 1)
                    created_at = datetime.datetime.now()
                    updated_at = datetime.datetime.now()
    ##                print (created_at)
                    start_date += datetime.timedelta(days=1)
                    if tdate in list_holiday : 
                        is_holiday = 1
                    else : 
                        is_holiday = 0
                    updateData(cursor, semester_id, tdate, week_num, weekday, is_holiday, created_at, updated_at)
    ##                print (tdate, weekday, week_num)
        cursor.close()
        connection.commit()
        connection.close()
        print ('Done!')

    batch()
