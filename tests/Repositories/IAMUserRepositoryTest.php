<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/23/17
 * Time: 13:55
 */

namespace thiagovictorino\IAM\Test\Repositories;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use thiagovictorino\IAM\Repositories\IAMUserRepository;
use thiagovictorino\IAM\Test\AbstractTestCase;

class IAMUserRepositoryTest extends AbstractTestCase {



    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $group_id = DB::table('iam_groups')->insertGetId(
            [
                'name' => 'Adimns',
                'uuid' => password_hash('Adimns'.microtime(),PASSWORD_DEFAULT),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $service_id = DB::table('iam_services')->insertGetId(
            [
                'name' => 'Test Service',
                'abbreviation' => 'TSR',
                'description' => 'Test',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $access_level_id = DB::table('iam_access_levels')->insertGetId(
            [
                'uuid' => password_hash('iam_access_levels'.microtime(),PASSWORD_DEFAULT),
                'name' => 'all',
                'iam_service_id' => $service_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $access_level_id2 = DB::table('iam_access_levels')->insertGetId(
            [
                'uuid' => password_hash('iam_access_levels'.microtime(),PASSWORD_DEFAULT),
                'name' => '123',
                'iam_service_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        DB::table('iam_groups_has_access_levels')->insert(
            [
                'iam_group_id' => $group_id,
                'iam_access_level_id' => $access_level_id,
            ]
        );

        DB::table('iam_groups_has_access_levels')->insert(
            [
                'iam_group_id' => $group_id,
                'iam_access_level_id' => $access_level_id2,
            ]
        );

        DB::table('iam_users_has_groups')->insert(
            [
                'iam_group_id' => $group_id,
                'iam_user_id' => 1,
            ]
        );



    }

    public function test_IAMUserRepositoryTest_getAccess(){

        $repository = new IAMUserRepository();

        $user = $repository->find(1);

        $a = $repository->getAccess($user);

        $this->assertTrue(in_array(123, $a["IAM"]['access']));

    }

    public function test_IAMUserRepositoryTest_saveToken(){
        $repository = new IAMUserRepository();
        $user = $repository->find(1);

        $repository->saveToken(123,$user->id);
    }
    public function test_IAMUserRepositoryTest_saveToken_already(){
        $repository = new IAMUserRepository();
        $user = $repository->find(1);

        DB::table('iam_users_has_tokens')->insert([
            'iam_users_id' => $user->id,
            'token' => 123,
            'logged_at' => Carbon::now(),
        ]);

        $repository->saveToken(123,$user->id);
    }

}