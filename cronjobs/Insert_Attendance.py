import pymysql
import os
import datetime


_host = 'localhost'
_user = 'root'
_password = 'abcd1234'
_database = 'atk_ble2'#'wired-noticeboard'

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
        # print(10)
    except Exception :
        error = "This student was take attendance"

def get_attendance(cursor) :
    sql = "SELECT student_id, lesson_date_id FROM attendance"
    cursor.execute(sql)
    return cursor.fetchall()

def get_all_semmester(cursor):
    sql = "SELECT start_date, end_date " \
          "FROM semester_info"
    cursor.execute(sql)
    return cursor.fetchall()

if __name__ == '__main__' :
    print('Start')
    connection = pymysql.connect(host=_host,
                                 user=_user,
                                 password=_password,
                                 database=_database)
    cursor = connection.cursor()
    list_semester = get_all_semmester(cursor)
    print(list_semester)
    yesterday = datetime.datetime.now().date() - datetime.timedelta(days = 1)
    for a in list_semester :
        start_date = a[0]
        end_date = a[1]
        end_date_ = datetime.datetime.now().date() - datetime.timedelta(days=1)

        if (start_date < yesterday) & (yesterday < end_date) :
            while(start_date < end_date_) :
                list_lesson_id = get_lesson_id_at_date(cursor, start_date)
                start_date  = start_date + datetime.timedelta(days=1)
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

