<?php
namespace tests\codeception\api;


use tests\codeception\api\FunctionalTester;


class LessonCest
{
    private $accessToken;

    public function _before(FunctionalTester $I)
    {
        $this->accessToken = $I->loginStudent()->token;
        $I->amBearerAuthenticated($this->accessToken);
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function getCurrentClasses(FunctionalTester $I)
    {
        $I->wantTo('get my current classes');
        $I->sendGET('v1/lesson/current-classes');
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType([
            'class_section' => 'string',
            'attendances' => 'array'
        ], '$[*]');
        $userId = $I->grabFromDatabase('user', 'id', [
            'username' => 'canhnht'
        ]);
        $studentId = $I->grabFromDatabase('student', 'id', [
            'user_id' => $userId
        ]);
        $response = json_decode($I->grabResponse());
        for ($iter = 0; $iter < count($response); ++$iter) {
            $class = $response[$iter];
            foreach ($class->attendances as $attendance) {
                $I->assertEquals($studentId, $attendance->student_id);
            }
        }
    }
}
