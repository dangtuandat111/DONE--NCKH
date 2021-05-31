<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('account')->insert([
        //     ['username' => 'BM_MMT',
        //     'email' => 'bm.mmt.utc@gmail.com',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'DANG TUAN DAT',
        //     'email' => 'mrboss862000@gmail.com',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'NGUYEN THANH TOAN',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'PHAM THANH HA',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'BUI NGOC DUNG',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'BUI NGOC DUNG',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'NGUYEN QUOC TUAN',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'LAI MANH DUNG',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'TRAN VU HIEU',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        // DB::table('account')->insert([
        //     ['username' => 'TIEU THI NGOC DUNG',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        //    DB::table('account')->insert([
        //     ['username' => 'NGUYEN KIM SAO',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        //    DB::table('account')->insert([
        //     ['username' => 'NGUYEN THI HONG HOA',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        //    DB::table('account')->insert([
        //     ['username' => 'NGUYEN TRAN HIEU',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 2],
        // ]);

        //  DB::table('account')->insert([
        //     ['username' => '6699',
        //     'email' => '',
        //     'password' => bcrypt('123'),
        //     'permission' => 1],
        // ]);

         DB::table('account')->insert([
            ['username' => 'QuanLyPhongHoc',
            'email' => 'qlph@gmail.com',
            'password' => bcrypt('123'),
            'permission' => 5],
        ]);
    }
}
