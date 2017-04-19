import pymysql
import os
import datetime


_host = 'localhost'
_user = 'root'
_password = 'abcd1234'
_database = 'atk-ble2'#'wired-noticeboard'

def get_lesson_id_at_date(cursor, ldate) :
    sql = "SELECT lesson_date.lesson_id, lesson_date.id " \
          "FROM lesson_date " \
          "WHERE ldate = '%s'"  %ldate

    cursor.execute(sql)
    return cursor.fetchall()

def get_time_table(cursor, lesson_id) :
    sql = "SELECT timetable.student_id FROM timetable " \
          "WHERE lesson_id = %s" % lesson_id
  #  print(sql)
    cursor.execute(sql)
    return cursor.fetchall()

def insert_attendance(cursor, student_id, lesson_date_id, recorded_time, status) :
    a = 1
    sql = "INSERT INTO attendance (student_id, lesson_date_id, recorded_time, status)" \
          "VALUES (%s, %s, '%s', %s )" %(student_id, lesson_date_id, recorded_time, status)
  #  print(sql)
    try:
        cursor.execute(sql)
     #   print(10)
    except Exception :
        error = "This student was take attendance"

def get_attendance(cursor) :
    sql = "SELECT student_id, lesson_date_id FROM attendance"
    cursor.execute(sql)
    return cursor.fetchall()

if __name__ == '__main__' :
    print('Start')
    connection = pymysql.connect(host=_host,
                                 user=_user,
                                 password=_password,
                                 database=_database)
    cursor = connection.cursor()

    yesterday = datetime.datetime.now().date() - datetime.timedelta(days = 1)
    list_lesson_id = get_lesson_id_at_date(cursor, yesterday)
    tmp = get_attendance(cursor)
    list_attendance = []
    for a in tmp :
        t = str(a[0]) + "a" + str(a[1])
        list_attendance.append(t)

    for a in list_lesson_id :
        lesson_id = a[0]
        lesson_date_id = a[1]
        #print(lesson_id)
        list_timetable = get_time_table(cursor, lesson_id)
        for b in list_timetable :
            student_id = b[0]
            recorded_time = datetime.datetime.now().time()
            status = -1
            insert_attendance(cursor, student_id, lesson_date_id, recorded_time, status)


    cursor.close()
    connection.commit()
    connection.close()
    print("Finish")

