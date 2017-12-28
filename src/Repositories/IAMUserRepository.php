<?php namespace thiagovictorino\IAM\Repositories;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use thiagovictorino\IAM\Entities\IAMUserEntity;
use thiagovictorino\IAM\Exceptions\AuthenticationFailException;
use thiagovictorino\MyArch\Repositories\RepositoryAbstract;

/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 10/5/17
 * Time: 15:28
 */


class IAMUserRepository extends RepositoryAbstract {

   public function __construct(){

       $this->entity = new IAMUserEntity();
   }

    /**
     * @param string $username
     * @param string $password
     * @return IAMUserEntity
     * @throws AuthenticationFailException
     */
   public function auth(string $username, string $password): IAMUserEntity{


       $user = $this->entity->where('username',$username)->get();

       if(count($user) == 0 ){
           throw new AuthenticationFailException('User not found');
       }

       $user = $user->first();

       if(!password_verify($password, $user->password)){
           throw new AuthenticationFailException('User or password is wrong');
       }

       if(!$user->active){
           throw new AuthenticationFailException('User not active');
       }

       $user->logged_at = Carbon::now();

       $user->save();

       return $user;
   }

   public function getAccess(IAMUserEntity $userEntity){
       $userAccess = $this->getUserAccess($userEntity->id);
       $groupAccess = $this->getGroupAccess($userEntity->id);

       $result = $this->mount($userAccess);
       $result = $this->mount($groupAccess, $result);

       return $result;
   }

   private function getUserAccess(int $userId){

       $sql = "SELECT iam_access_levels.name as access_name,iam_services.abbreviation, iam_services.name, iam_services.description from iam_users_has_access_levels,iam_users,iam_access_levels,iam_services  WHERE  
                iam_users.id = iam_users_has_access_levels.iam_user_id AND 
                iam_access_levels.id = iam_users_has_access_levels.iam_access_level_id AND 
                iam_services.id = iam_access_levels.iam_service_id AND 
                iam_users.id = ".$userId."  AND 
                iam_access_levels.active AND
                iam_services.active
              ";

       return DB::select(DB::raw($sql));

   }

   private function mount($results, $arr = []){

       foreach($results as $result){

           if(!array_key_exists($result->abbreviation, $arr)){
               $arr[$result->abbreviation]['name'] = $result->name;
               $arr[$result->abbreviation]['description'] = $result->name;
               $arr[$result->abbreviation]['access'] =  [];
           }

           $arr[$result->abbreviation]['access'][] = $result->access_name;
       }

       return $arr;
   }

    private function getGroupAccess(int $userId){

        $sql = "SELECT iam_access_levels.name as access_name,iam_services.abbreviation, iam_services.name, iam_services.description 
                FROM iam_groups_has_access_levels,iam_groups,iam_access_levels,iam_services  WHERE  
                iam_groups.id = iam_groups_has_access_levels.iam_group_id AND 
                iam_access_levels.id = iam_groups_has_access_levels.iam_access_level_id AND 
                iam_services.id = iam_access_levels.iam_service_id AND 
                iam_groups.id in (SELECT iam_groups.id FROM iam_users_has_groups WHERE iam_user_id = ".$userId.") AND 
                iam_access_levels.active AND
                iam_services.active AND
                iam_groups.active;
              ";

        return DB::select(DB::raw($sql));
    }

    public function saveToken(string $token, int $user_id){

        try{

            DB::table('iam_users_has_tokens')->insert([
                'iam_users_id' => $user_id,
                'token' => $token,
                'logged_at' => Carbon::now(),
            ]);

        }catch (QueryException $queryException){

            DB::table('iam_users_has_tokens')
                ->where('iam_users_id',$user_id)
                ->where('token',$token)
                ->update(['logged_at'=>Carbon::now()]);
        }



    }
}






