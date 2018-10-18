<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_csv', function ($attribute, $value, $parameters, $validator) {
            $values = explode(',', $value);

            $table  = array_shift($parameters);
            $column = array_shift($parameters);

            $errorVals = [];
            $errors    = false;

            foreach ($values as $currentValue) {
                $result = DB::table($table)->select(DB::raw(1))->where($column, '=', $currentValue)->first();

                if (!empty($result)) {
                    $errorVals[] = $currentValue;
                    $errors      = true;
                }
            }

            if ($errors) {
                $errorVals = implode(', ', $errorVals);
                $validator->errors()->add('bar_code', "Los códigos de barra ($errorVals) ya están registrados.");
            }

            return !$errors;
        }, '&nbsp;');

        Validator::extend('unique_csv_ed', function ($attribute, $value, $parameters, $validator) {
            $values = explode(',', $value);

            $table     = array_shift($parameters);
            $column    = array_shift($parameters);
            $column_id = array_shift($parameters);
            $product   = array_shift($parameters);

            $errorVals = [];
            $errors    = false;

            foreach ($values as $currentValue) {
                $result = DB::table($table)->select(DB::raw(1))->where($column, '=', $currentValue)->where($column_id, '<>', $product)->first();

                if (!empty($result)) {
                    $errorVals[] = $currentValue;
                    $errors      = true;
                }
            }

            if ($errors) {
                $errorVals = implode(', ', $errorVals);
                $validator->errors()->add('bar_code', "Los códigos de barra ($errorVals) ya están registrados.");
            }

            return !$errors;
        }, '&nbsp;');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
