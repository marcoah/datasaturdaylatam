<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $template = new Template();
        $template->title = 'Bienvenida';
        $template->subject = 'Bienvenido';
        $template->content_1 = 'Hola bienvenido';
        $template->slug = 'bienvenido';
        $template->tags = ['Notification', 'E-mail', 'Account', 'Welcome'];
        $template->mailable_class = 'Bienvenida';
        $template->use = 'Para dar la bienvenida a los ponentes y asistentes';
        $template->save();

        $template = new Template();
        $template->title = 'Recordatorio';
        $template->subject = 'Recordatorio';
        $template->content_1 = 'Recordatorio';
        $template->slug = 'recordatorio';
        $template->tags = ['Notification', 'E-mail', 'Account', 'Reminder'];
        $template->mailable_class = 'Recordatorio';
        $template->use = 'Para el recordatorio dias antes del evento';
        $template->save();

        $template = new Template();
        $template->title = 'Agradecimiento';
        $template->subject = 'Agradecimiento';
        $template->content_1 = 'Muchas gracias por tu participacion';
        $template->slug = 'agradecimiento';
        $template->tags = ['Notification', 'E-mail', 'Account', 'Thanks'];
        $template->mailable_class = 'Agradecimiento';
        $template->use = 'Para el agradecimiento por asistir al evento';
        $template->save();
    }
}
