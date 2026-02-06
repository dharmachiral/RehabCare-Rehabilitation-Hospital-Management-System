<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Modules\Student\Entities\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GenerateStudentUsers extends Command
{
    protected $signature = 'generate:student-users';
    protected $description = 'Create users for existing students even if user_id exists but user is missing';

    public function handle()
    {
        $students = Student::all(); // get all students
        $count = 0;

        DB::beginTransaction();

        try {
            foreach ($students as $student) {
                // Check if user exists
                $userExists = $student->user()->exists();

                if ($userExists) {
                    continue; // skip if user already exists
                }

                // Generate username and password
                $username = strtolower(Str::slug($student->full_name)) . rand(1000, 9999);
                $passwordPlain = $student->full_name . '@123';

                // Create user
                $user = User::create([
                    'username' => $username,
                    'email' => $username . '@student.local',
                    'password' => Hash::make($passwordPlain),
                    'role' => 'student',
                ]);

                // Link student with new user
                $student->user_id = $user->id;
                $student->save();

                // Save login info
                file_put_contents(
                    storage_path('student_logins.txt'),
                    "{$student->full_name} | {$username} | {$passwordPlain}\n",
                    FILE_APPEND
                );

                $count++;
            }

            DB::commit();
            $this->info("✅ Created {$count} missing users for existing students.");
            $this->info("Credentials saved in storage/student_logins.txt");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Failed: " . $e->getMessage());
        }
    }
}
