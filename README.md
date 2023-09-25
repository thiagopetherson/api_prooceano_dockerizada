# API do Sistema Proposto Pela da Prooceano

Projeto de um sistema de armazenamento de geolocalizações e informações.<br/><br/>



## 📋 Detalhes


Desenvolvimento de uma API em Laravel 9 com quatro tabelas: users, devices, locations e device_locations. Onde algumas delas se relacionam.

- A tabela users possui os campos (id, name, email, password, is_admin, created_at e updated_at).<br/>
- A tabela devices possui os campos (id, name, description, created_at e updated_at)<br/>
- A tabela locations possui os campos (id, name, latitude, longitude, created_at e updated_at).<br/>
- A tabela devices_locations possui os campos (id, device_id, latitude, longitude, temperature, salinity, created_at e updated_at).<br/><br/>


## 🚀 Link da Aplicação

Aplicação hospedada:<br/>
Link: https://prooceano.netlify.app/<br/><br/>



## 🛠️ Pré-requisitos


Você precisa ter instalado em sua máquina:

- Composer<br/>
- Laravel<br/><br/>


## 📦 Desenvolvimento Backend (Ferramentas utilizadas na API Laravel)

- Laravel 9
- Rotas e Métodos Resources.<br/>
- Métodos de Relacionamentos Has Many - Joins de Tabelas<br/>
- Autenticação com Sanctum<br/>
- Form Requests - Validação<br/>
- Factories e Seeders - Para Popular o Banco<br/>
- Testes Automatizados - PHPUnit<br/>
- Helpers - Reutilização e Clean Code<br/>
- Envio de Email - Usando o Mail do Laravel<br/>
- Schedules e Cronjob - Agendamento e Automação de tarefas<br/>
- Websockets e Eventos<br/>
- Deploy Automatizado - Deploy Automatizado Entre Github e Heroku<br/>

<br/>



## 🔧 Instalação e Inicialização do Projeto (Laravel 9)


Na pasta raiz da aplicação rode no terminal:

`composer install`
 <br/>

Rode o comando abaixo (No terminal, na pasta raiz do projeto), para criação das tabelas no banco:
 
`php artisan migrate`
<br/>

Rode o comando abaixo (No terminal, na pasta raiz do projeto), para criação dos 2(dois) equipamentos (Atlas e Baleia):
 
`php artisan db:seed --class=DeviceSeeder`
<br/>

Por fim, rodamos o comando abaixo, que roda nossa aplicação backend laravel (No terminal, na pasta raiz do projeto):

`php artisan serve`
<br/>

Caso queira rodar os testes implementados, rode o comando: 
 
`php artisan teste` ou `./vendor/bin/phpunit`
<br/>

Para rodar os crons implementados (e criar as localizações dos dispositivos), rodar o(s) comando:

`php artisan firstDeviceLocation:cron` e/ou `php artisan secondDeviceLocation:cron`
<br/>

Para rodar o websocket, rodar o comando:

`php artisan websockets:serve`
<br/><br/>

![image](https://user-images.githubusercontent.com/44420212/220792427-2b158ed7-1a25-4588-a0ea-a7843b37a713.png)



<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
