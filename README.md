<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Recuirement

- [Git](https://git-scm.com/downloads).
- [Composer](https://getcomposer.org/download/).
- [PHP ^8.1 dan MySQL](https://www.apachefriends.org/download.html).

## Cara Install

- Clone repository
  ```
  git clone https://github.com/rizqullohrayhan/bukutamu.git
  ```
- Masuk ke folder project
  ```
  cd bukutamu
  ```
- Install / update composer package
  ```
  composer install
  ```
  atau
  ```
  composer update
  ```
- Copy file .env.example
  ```
  cp .env.example .env
  ```
- Generate app key
  ```
  php artisan key:generate
  ```
- Sesuaikan file .env
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=buku_tamu
  DB_USERNAME=root
  DB_PASSWORD=
  ```
- Jalankan migration database
  ```
  php artisan migrate
  ```
- Jalankan Aplikasi
  ```
  php artisan serve
  ```
- Buka Aplikasi pada [127.0.0.1:8000](127.0.0.1:8000).
