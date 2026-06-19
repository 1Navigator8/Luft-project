# Luft Projekt - Документ проекта

Это заглушка для документа Word. Пожалуйста, замените этот файл на ваш реальный документ luft_projekt.docx.

## Структура проекта

- **index.php** - Основной файл сайта
- **counters/** - Папка для счетчиков и кэша
- **downloads/** - Папка для файлов проекта
- **assets/** - Локальные ресурсы
  - **fonts/** - Локальные шрифты
  - **icons/** - Локальные иконки
  - **images/** - Изображения для галереи

## Функциональность

- Счетчик посетителей (visitors.txt)
- Счетчик скачиваний (downloads.txt)
- Кэширование погодных данных (weather_cache.json)
- Галерея изображений по теме атмосферы
- Ссылка для скачивания проекта

## Инструкция по настройке

1. Убедитесь, что папки `counters/`, `downloads/`, `assets/` существуют
2. Назначьте права на запись для папки `counters/` (для PHP-скриптов)
3. Загрузите свои изображения в `assets/images/`
4. Создайте свой документ Word и положите его в `downloads/luft_projekt.docx`
5. Настраивайте API погоды в `api/weather.php` по желанию

## Графика

Используйте SVG-иконки, встроенные в HTML для автономности.

## Технологии

- PHP 7.4+
- HTML5
- CSS3
- JavaScript (ES6+)
- JSON для кэширования данных

luft-projekt/
├── index.php # Основной файл сайта (PHP + HTML)
├── assets/ # Все локальные ресурсы
│ ├── css/
│ │ └── styles.css # Все стили вынесены отдельно
│ ├── fonts/ # Локальные шрифты (Segoe UI)
│ │ ├── SegoeUI-Regular.woff2
│ │ ├── SegoeUI-Bold.woff2
│ │ └── SegoeUI-Medium.woff2
│ ├── icons/ # Иконки (SVG, локально)
│ │ ├── sun.svg
│ │ ├── wind.svg
│ │ ├── humidity.svg
│ │ └── download.svg
│ └── images/ # Изображения для галереи
│ ├── experiment-spritze.jpg
│ ├── experiment-flasche.jpg
│ ├── atmosphaere-schichten.jpg
│ └── heissluftballon.jpg
├── counters/ # Счетчики и кэш
│ ├── visitors.txt;
│ ├── downloads.txt
│ └── weather_cache.json
└── downloads/ # Файл для скачивания
└── luft_projekt.docx

## Лицензия

© 2024 Luft Projekt. Все права защищены.

Откройте Терминал прямо внутри VS Code (нажмите комбинацию клавиш `Ctrl + `` — это клавиша с буквой Ё, либо выберите в верхнем меню Terminal -> New Terminal).Введите туда следующую команду и нажмите Enter:bashC:\php\php.exe -S localhost:8000
Verwende Code mit Vorsicht.Откройте ваш браузер и перейдите по адресу: http://localhost:8000Сайт гарантированно откроется без ошибок, и все внутренние скрипты будут работать корректно. Чтобы остановить его в будущем, просто нажмите Ctrl + C в этом терминале.
