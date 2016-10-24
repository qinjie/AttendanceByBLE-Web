<?php
namespace tests\codeception\api;


use tests\codeception\api\FunctionalTester;
use common\components\Util;

class TimetableLecturerCest
{
    private $accessToken;

    public function _before(FunctionalTester $I)
    {
        $this->accessToken = $I->loginLecturer()->token;
        $I->amBearerAuthenticated($this->accessToken);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function getLecturerTimetable_Today(FunctionalTester $I)
    {
        $I->wantTo('get my lecturer timetable of today');
        $I->sendGET('v1/attendance/day', [
            'expand' => 'lesson,venue'
        ]);
        $I->seeResponseCodeIs(200);
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'zhangqinjie'
        ]);
        $lecturerId = $I->grabFromDatabase('lecturer', 'id', [
            'user_id' => $userId
        ]);
        $response = json_decode($I->grabResponse());
        foreach ($response as $item) {
            $I->assertEquals($lecturerId, $item->lecturer_id);
            $I->assertEquals(date('Y-m-d'), $item->recorded_date);
            $I->assertEquals(Util::getWeekday(strtotime(date('Y-m-d'))), $item->lesson->weekday);
        }
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'student_id' => 'string',
            'lecturer_id' => 'string',
            'lesson_id' => 'integer',
            'recorded_date' => 'string',
            'lesson' => [
                'id' => 'integer',
                'semester' => 'string',
                'module_id' => 'string',
                'venue_id' => 'integer',
                'weekday' => 'string',
                'start_time' => 'string',
                'end_time' => 'string',
                'meeting_pattern' => 'string'
            ],
            'venue' => [
                'location' => 'string',
                'name' => 'string'
            ]
        ], '$[*]');
    }

    public function getLecturerTimetable_OneDay(FunctionalTester $I)
    {
        $I->wantTo('get my lecturer timetable of an arbitrary day');
        $I->sendGET('v1/attendance/day', [
            'recorded_date' => '2016-10-12',
            'expand' => 'lesson,venue'
        ]);
        $I->seeResponseCodeIs(200);
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'zhangqinjie'
        ]);
        $lecturerId = $I->grabFromDatabase('lecturer', 'id', [
            'user_id' => $userId
        ]);
        $response = json_decode($I->grabResponse());
        foreach ($response as $item) {
            $I->assertEquals($lecturerId, $item->lecturer_id);
            $I->assertEquals('2016-10-12', $item->recorded_date);
            $I->assertEquals(Util::getWeekday(strtotime('2016-10-12')), $item->lesson->weekday);
        }
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'student_id' => 'string',
            'lecturer_id' => 'string',
            'lesson_id' => 'integer',
            'recorded_date' => 'string',
            'lesson' => [
                'id' => 'integer',
                'semester' => 'string',
                'module_id' => 'string',
                'venue_id' => 'integer',
                'weekday' => 'string',
                'start_time' => 'string',
                'end_time' => 'string',
                'meeting_pattern' => 'string'
            ],
            'venue' => [
                'location' => 'string',
                'name' => 'string'
            ]
        ], '$[*]');
    }

    public function getLecturerTimetable_CurrentWeek(FunctionalTester $I)
    {
        $I->wantTo('get my lecturer timetable of current week');
        $I->sendGET('v1/attendance/week', [
            'expand' => 'lesson,venue'
        ]);
        $I->seeResponseCodeIs(200);
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'zhangqinjie'
        ]);
        $lecturerId = $I->grabFromDatabase('lecturer', 'id', [
            'user_id' => $userId
        ]);
        $week = Util::getWeekInSemester(strtotime('2016-10-3'), strtotime(date('Y-m-d')));
        $startDate = Util::getStartDateInWeek(strtotime('2016-10-3'), $week);
        $endDate = Util::getEndDateInWeek(strtotime('2016-10-3'), $week);
        $response = json_decode($I->grabResponse());
        foreach ($response as $item) {
            $I->assertEquals($lecturerId, $item->lecturer_id);
            $I->assertGreaterThanOrEqual($startDate, $item->recorded_date);
            $I->assertLessThanOrEqual($endDate, $item->recorded_date);
            $I->assertNotEquals('ODD', $item->lesson->meeting_pattern);
        }
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'student_id' => 'string',
            'lesson_id' => 'integer',
            'recorded_date' => 'string',
            'lesson' => [
                'id' => 'integer',
                'semester' => 'string',
                'module_id' => 'string',
                'venue_id' => 'integer',
                'weekday' => 'string',
                'start_time' => 'string',
                'end_time' => 'string',
                'meeting_pattern' => 'string'
            ],
            'venue' => [
                'location' => 'string',
                'name' => 'string'
            ]
        ], '$[*]');
    }

    public function getLecturerTimetable_OneWeek(FunctionalTester $I)
    {
        $I->wantTo('get my lecturer timetable of current week');
        $I->sendGET('v1/attendance/week', [
            'weekNumber' => 1,
            'expand' => 'lesson,venue'
        ]);
        $I->seeResponseCodeIs(200);
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'zhangqinjie'
        ]);
        $lecturerId = $I->grabFromDatabase('lecturer', 'id', [
            'user_id' => $userId
        ]);
        $startDate = Util::getStartDateInWeek(strtotime('2016-10-3'), 1);
        $endDate = Util::getEndDateInWeek(strtotime('2016-10-3'), 1);
        $response = json_decode($I->grabResponse());
        foreach ($response as $item) {
            $I->assertEquals($lecturerId, $item->lecturer_id);
            $I->assertGreaterThanOrEqual($startDate, $item->recorded_date);
            $I->assertLessThanOrEqual($endDate, $item->recorded_date);
            $I->assertNotEquals('EVEN', $item->lesson->meeting_pattern);
        }
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'student_id' => 'string',
            'lesson_id' => 'integer',
            'recorded_date' => 'string',
            'lesson' => [
                'id' => 'integer',
                'semester' => 'string',
                'module_id' => 'string',
                'venue_id' => 'integer',
                'weekday' => 'string',
                'start_time' => 'string',
                'end_time' => 'string',
                'meeting_pattern' => 'string'
            ],
            'venue' => [
                'location' => 'string',
                'name' => 'string'
            ]
        ], '$[*]');
    }

    public function getLecturerTimetable_CurrentSemester(FunctionalTester $I)
    {
        $I->wantTo('get my lecturer timetable of current semester');
        $I->sendGET('v1/attendance/semester', [
            'expand' => 'lesson,student,venue'
        ]);
        $I->seeResponseCodeIs(200);
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'zhangqinjie'
        ]);
        $lecturerId = $I->grabFromDatabase('lecturer', 'id', [
            'user_id' => $userId
        ]);
        $fromDate = date('Y-m-d');
        $response = json_decode($I->grabResponse());
        foreach ($response as $item) {
            $I->assertEquals($lecturerId, $item->lecturer_id);
            $I->assertLessThanOrEqual($fromDate, $item->recorded_date);
            $I->assertEquals($item->lesson->id, $item->lesson_id);
            $I->assertEquals($item->student->id, $item->student_id);
        }
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'student_id' => 'string',
            'lesson_id' => 'integer',
            'recorded_date' => 'string',
            'lesson' => [
                'id' => 'integer',
                'semester' => 'string',
                'module_id' => 'string',
                'venue_id' => 'integer',
                'weekday' => 'string',
                'start_time' => 'string',
                'end_time' => 'string',
                'meeting_pattern' => 'string'
            ],
            'student' => [
                'id' => 'string',
                'name' => 'string',
                'acad' => 'string',
                'user_id' => 'integer'
            ],
            'venue' => [
                'location' => 'string',
                'name' => 'string'
            ]
        ], '$[*]');
    }

    public function getLecturerTimetable_ForAClass_CurrentSemester(FunctionalTester $I)
    {
        $I->wantTo('get my lecturer timetable for a class of current semester');
        $I->sendGET('v1/attendance/semester', [
            'class_section' => 'LL12',
            'expand' => 'lesson,student,venue'
        ]);
        $I->seeResponseCodeIs(200);
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'zhangqinjie'
        ]);
        $lecturerId = $I->grabFromDatabase('lecturer', 'id', [
            'user_id' => $userId
        ]);
        $fromDate = date('Y-m-d');
        $response = json_decode($I->grabResponse());
        foreach ($response as $item) {
            $I->assertEquals('LL12', $item->lesson->class_section);
            $I->assertEquals($lecturerId, $item->lecturer_id);
            $I->assertLessThanOrEqual($fromDate, $item->recorded_date);
            $I->assertEquals($item->lesson->id, $item->lesson_id);
            $I->assertEquals($item->student->id, $item->student_id);
        }
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'student_id' => 'string',
            'lesson_id' => 'integer',
            'recorded_date' => 'string',
            'lesson' => [
                'id' => 'integer',
                'semester' => 'string',
                'module_id' => 'string',
                'venue_id' => 'integer',
                'weekday' => 'string',
                'start_time' => 'string',
                'end_time' => 'string',
                'meeting_pattern' => 'string'
            ],
            'student' => [
                'id' => 'string',
                'name' => 'string',
                'acad' => 'string',
                'user_id' => 'integer'
            ],
            'venue' => [
                'location' => 'string',
                'name' => 'string'
            ]
        ], '$[*]');
    }

    public function getLecturerTimetable_FromOneDay_CurrentSemester(FunctionalTester $I)
    {
        $I->wantTo('get my lecturer timetable for a day of current semester');
        $I->sendGET('v1/attendance/semester', [
            'fromDate' => '2016-10-05',
            'expand' => 'lesson,student,venue'
        ]);
        $I->seeResponseCodeIs(200);
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'zhangqinjie'
        ]);
        $lecturerId = $I->grabFromDatabase('lecturer', 'id', [
            'user_id' => $userId
        ]);
        $fromDate = '2016-10-05';
        $response = json_decode($I->grabResponse());
        foreach ($response as $item) {
            $I->assertEquals($lecturerId, $item->lecturer_id);
            $I->assertLessThanOrEqual($fromDate, $item->recorded_date);
            $I->assertEquals($item->lesson->id, $item->lesson_id);
            $I->assertEquals($item->student->id, $item->student_id);
        }
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'student_id' => 'string',
            'lesson_id' => 'integer',
            'recorded_date' => 'string',
            'lesson' => [
                'id' => 'integer',
                'semester' => 'string',
                'module_id' => 'string',
                'venue_id' => 'integer',
                'weekday' => 'string',
                'start_time' => 'string',
                'end_time' => 'string',
                'meeting_pattern' => 'string'
            ],
            'student' => [
                'id' => 'string',
                'name' => 'string',
                'acad' => 'string',
                'user_id' => 'integer'
            ],
            'venue' => [
                'location' => 'string',
                'name' => 'string'
            ]
        ], '$[*]');
    }
}
