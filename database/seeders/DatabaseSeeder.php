<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Course;
use App\Models\Image;
use App\Models\Lesson;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Role::create(['role' => 'admin']);
        Role::create(['role' => 'student']);
        Role::create(['role' => 'teacher']);

        User::factory(40)->create();

        $users = User::whereRelation('role', 'role', 'student')->get();

        Category::factory(10)->create();

        $Courses = Course::factory(15)->create();

        Lesson::factory(40)->create();

        Image::factory(20)->create();

        $users->each(
            function (User $user){
                $user->enrollments()->sync([Course::all()->random()->id]);
            }
        );
    }
}
