<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*', function($view) {
            //スコア、生徒の一覧取得
            $score_model = new Score();
            $scores = $score_model->getMyScore();

            $students = Student::whereNull('deleted_at')
                    ->orderBy('id', 'ASC')
                    ->get();
            $subjects = Subject::orderBy('id', 'ASC')
                    ->get();

            $view->with('scores', $scores);
            $view->with('students', $students);
            $view->with('subjects', $subjects);
        });
    }
}
