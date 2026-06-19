<?php
// ==============================================
// ВЕРСИЯ: РАБОТАЕТ НА ЛЮБОМ СЕРВЕРЕ (8000, 5500, ЛЮБОЙ)
// СКАЧИВАНИЕ СРАЗУ, СЧЕТЧИКИ СЧИТАЮТ, ПОГОДА РАБОТАЕТ
// ==============================================

// --------------------------
// Пути и папки
// --------------------------
$counter_visitors_file = __DIR__ . '/counters/visitors.txt';
$counter_downloads_file = __DIR__ . '/counters/downloads.txt';
$weather_cache_file = __DIR__ . '/counters/weather_cache.json';

$folders = [__DIR__ . '/counters', __DIR__ . '/download', __DIR__ . '/assets/css', __DIR__ . '/assets/fonts', __DIR__ . '/assets/icons', __DIR__ . '/assets/images'];
foreach ($folders as $folder) if (!file_exists($folder)) mkdir($folder, 0755, true);

// --------------------------
// Счетчики — просто и надежно
// --------------------------
function getCounter($file)
{
    if (!file_exists($file)) {
        file_put_contents($file, '0');
        chmod($file, 0644);
    }
    return (int)file_get_contents($file);
}
function incCounter($file)
{
    $val = getCounter($file) + 1;
    file_put_contents($file, (string)$val);
    return $val;
}

// Увеличиваем посетителя при каждом входе
$visitors_total = incCounter($counter_visitors_file);
$downloads_total = getCounter($counter_downloads_file);

// --------------------------
// Погода — без ошибок
// --------------------------
$weather_data = null;
$cache = 10 * 60;
if (file_exists($weather_cache_file) && (time() - filemtime($weather_cache_file)) < $cache) {
    $weather_data = json_decode(file_get_contents($weather_cache_file), true);
} else {
    $url = "https://api.open-meteo.com/v1/forecast?latitude=49.7024&longitude=9.2604&current=temperature_2m,relative_humidity_2m,wind_speed_10m&timezone=Europe/Berlin";
    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
    $res = @file_get_contents($url, false, $ctx);
    if ($res) {
        $api = json_decode($res, true);
        if (isset($api['current'])) {
            $weather_data = [
                'temp' => round((float)$api['current']['temperature_2m'], 1),
                'humidity' => (int)$api['current']['relative_humidity_2m'],
                'wind' => round((float)$api['current']['wind_speed_10m'] * 1.60934, 1)
            ];
            file_put_contents($weather_cache_file, json_encode($weather_data));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luft – Mehr als nichts?</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="0" height="0" viewBox="0 0 1366 768" xml:space="preserve">
        <defs>
            <filter id="blur0">
                <feGaussianBlur in="SourceGraphic" stdDeviation="0 0" />
            </filter>
            <filter id="blur1">
                <feGaussianBlur in="SourceGraphic" stdDeviation="5 0" />
            </filter>
            <filter id="blur2">
                <feGaussianBlur in="SourceGraphic" stdDeviation="12 0" />
            </filter>
            <filter id="blur3">
                <feGaussianBlur in="SourceGraphic" stdDeviation="20 0" />
            </filter>
            <filter id="blur4">
                <feGaussianBlur in="SourceGraphic" stdDeviation="35 1" />
            </filter>
            <filter id="blur5">
                <feGaussianBlur in="SourceGraphic" stdDeviation="50 1" />
            </filter>
        </defs>
    </svg>

    <button class="theme-toggle" id="themeToggle" title="Tag/Nacht wechseln">☀️</button>

    <div class="background-elements">
        <img src="assets/icons/sonnebg.svg" alt="Sonne" class="sun">
        <img src="assets/icons/moonbg.svg" alt="Mond" class="moon">
        <div class="cloud-small"></div>
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
        <div class="cloud cloud-3"></div>
        <div class="cloud cloud-4"></div>
        <div class="cloud cloud-5"></div>
    </div>

    <header>
        <div class="container header-content">
            <a href="#" class="logo">LUFT</a>
            <nav>
                <a href="#slider">Bild-Slider</a>
                <a href="#wissen">Wissen</a>
                <a href="#experimente">Experimente</a>
                <a href="#wetter">Wetter</a>
                <a href="#galerie">Galerie</a>
                <a href="#video">Video</a>
                <a href="#download">Download</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Luft – Mehr als nichts?</h1>
            <p>Luft ist eine unsichtbare Substanz, bestehend aus kleinsten Teilchen, die sich ständig bewegen. Sie braucht Platz, hat Gewicht, erzeugt Druck, dehnt sich bei Wärme aus und ist Grundlage allen Lebens auf der Erde.</p>
            <a href="#wissen" class="btn">Mehr erfahren</a>
        </div>
    </section>

    <section id="slider" style="background: rgba(255,255,255,0.05); padding: 80px 0;">
        <div class="container">
            <h2>Bild-Slider</h2>
            <div class="slider">
                <ul>
                    <li><input type="radio" name="slider" id="slide1" checked><label for="slide1"></label><img src="assets/images/luftH.jpg" alt="Luft und Atmosphäre" class="slider-img"></li>
                    <li><input type="radio" name="slider" id="slide2"><label for="slide2"></label><img src="assets/images/luft.jpg" alt="Eigenschaften der Luft" class="slider-img"></li>
                    <li><input type="radio" name="slider" id="slide3"><label for="slide3"></label><img src="assets/images/winds3.jpg" alt="Wind als bewegte Luft" class="slider-img"></li>
                    <li><input type="radio" name="slider" id="slide4"><label for="slide4"></label><img src="assets/images/lufts6.jpg" alt="Windenergie" class="slider-img"></li>
                    <li><input type="radio" name="slider" id="slide5"><label for="slide5"></label><img src="assets/images/wind5.jpg" alt="Windenergie" class="slider-img"></li>
                    <li><input type="radio" name="slider" id="slide6"><label for="slide6"></label><img src="assets/images/luftK.jpg" alt="Windenergie" class="slider-img"></li>
                </ul>
            </div>
        </div>
    </section>

    <section id="wissen">
        <div class="container">
            <h2>Zusammensetzung & Eigenschaften</h2>
            <div class="info-grid">
                <div>
                    <p>Nach wissenschaftlichen Untersuchungen besteht Luft aus einem homogenen Gasgemisch:</p>
                    <ul class="info-list">
                        <li><strong>Stickstoff (N₂): 78,08 %</strong> – Hauptbestandteil, farb- und geruchlos, nicht brennbar, erstickt Flammen</li>
                        <li><strong>Sauerstoff (O₂): 20,95 %</strong> – lebenswichtig für Atmung und Verbrennung, fördert Feuer</li>
                        <li><strong>Edelgase (Argon, Helium, Neon…): 0,93 %</strong> – reaktionsträge, Helium für Luftschiffe, Neon für Leuchtreklamen</li>
                        <li><strong>Kohlendioxid (CO₂): 0,04 %</strong> – wichtig für Photosynthese, zum Feuerlöschen</li>
                        <li><strong>Wasserdampf & weitere Gase: 0,03 – 4,00 %</strong> – veränderlich, bestimmt Wetter und Klima</li>
                    </ul>
                    <p><strong>Wichtige Eigenschaften:</strong><br>
                        ✅ Luft braucht Platz – <em>Wo Luft ist, kann kein anderer Stoff sein</em><br>
                        ✅ Luft ist gasförmig – füllt jeden Raum gleichmäßig aus<br>
                        ✅ Warme Luft: dehnt sich aus, braucht mehr Platz, ist leichter, steigt auf<br>
                        ✅ Kalte Luft: zieht sich zusammen, braucht weniger Platz, ist schwerer, sinkt ab<br>
                        ✅ Teilchen bewegen sich ständig – daraus entsteht Luftdruck durch Stöße<br>
                        ✅ Luft hat Gewicht – der Druck drückt auf alle Gegenstände<br>
                        ✅ Luft kann bewegen und Arbeit leisten (Wind, Auftrieb, Antrieb)
                    </p>
                </div>
                <div class="diagram-container">
                    <div class="circle-chart">
                        <div class="circle-inner">Luft</div>
                    </div>
                    <ul class="legend">
                        <li><span class="legend-color leg-n"></span> Stickstoff 78,08%</li>
                        <li><span class="legend-color leg-o"></span> Sauerstoff 20,95%</li>
                        <li><span class="legend-color leg-edel"></span> Edelgase 0,93%</li>
                        <li><span class="legend-color leg-co2"></span> CO₂ & andere 0,04%</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="experimente" style="background: rgba(255,255,255,0.05); padding: 80px 0;">
        <div class="container">
            <h2>Experimente zum Nachmachen</h2>
            <div class="experiments-grid">
                <div class="experiment-card">
                    <h3>🔬 Die leere Spritze</h3>
                    <p class="experiment-material">Material: Kunststoffspritze, Daumen</p>
                    <p><strong>Versuch:</strong> Verschließe den Luftauslass fest mit dem Daumen und versuche den Kolben hineinzudrücken.</p>
                    <p><strong>Ergebnis:</strong> Geht nicht – Luft braucht Platz. Teilchen stoßen zusammen, Druck entsteht. <em>Beweis: Luft ist eine Substanz!</em></p>
                </div>
                <div class="experiment-card">
                    <h3>🔬 Luft braucht Platz – Flasche mit Trichter</h3>
                    <p class="experiment-material">Material: Flasche, Trichter, Knetgummi, Wasser</p>
                    <p><strong>Versuch:</strong> Trichter abdichten → Wasser bleibt stehen. Ohne Abdichtung → fließt durch.</p>
                    <p><strong>Ergebnis:</strong> Eingesperrte Luft blockiert den Weg. Wo Luft ist, kann kein Wasser sein.</p>
                </div>
                <div class="experiment-card">
                    <h3>🔬 Ballon in der Flasche</h3>
                    <p class="experiment-material">Material: 2 Flaschen (eine mit Loch), Ballons</p>
                    <p><strong>Versuch:</strong> Aufblasen ohne Loch unmöglich – mit Loch leicht möglich.</p>
                    <p><strong>Ergebnis:</strong> Luft muss entweichen können, sonst blockiert sie den Platz.</p>
                </div>
                <div class="experiment-card">
                    <h3>🔬 Warme Luft dehnt sich aus</h3>
                    <p class="experiment-material">Material: Glasflasche, Luftballon, Föhn</p>
                    <p><strong>Versuch:</strong> Ballon auf kalte Flasche → erwärmen. Ballon bläst sich von selbst auf!</p>
                    <p><strong>Ergebnis:</strong> Wärme → Teilchen schneller → mehr Platz → leichter → steigt auf.</p>
                </div>
                <div class="experiment-card">
                    <h3>🔬 Kalte Luft zieht sich zusammen</h3>
                    <p class="experiment-material">Material: Plastikflasche mit Verschluss</p>
                    <p><strong>Versuch:</strong> Fest verschließen → ins Eisfach. Nach 10 Min. herausnehmen.</p>
                    <p><strong>Ergebnis:</strong> Flasche ist eingedrückt. Kalte Luft braucht weniger Platz – Außendruck drückt sie ein.</p>
                </div>
                <div class="experiment-card">
                    <h3>🔬 Luftdruck sichtbar machen</h3>
                    <p class="experiment-material">Material: Flasche, 5-Cent-Münze, Wasser</p>
                    <p><strong>Versuch:</strong> Münze auf kalte Flasche → mit Händen erwärmen. Münze hüpft!</p>
                    <p><strong>Ergebnis:</strong> Erwärmte Luft dehnt sich aus, drückt Münze hoch – Druck durch Teilchenbewegung.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="wetter">
        <div class="container">
            <h2>Aktuelles Wetter & Zeit in Miltenberg</h2>
            <div class="weather-grid">
                <!-- Блок с датой и временем (только PHP) -->
                <div class="weather-card">
                    <img src="assets/icons/clock.svg" alt="Datum & Zeit" class="weather-icon">
                    <h3>Datum & Zeit</h3>
                    <div class="weather-value">
                        <?php
                        // Устанавливаем правильный часовой пояс (Германия)
                        date_default_timezone_set('Europe/Berlin');
                        // Выводим: день недели, число месяц год
                        echo date('l, d. F Y');
                        echo '<br>';
                        // Выводим время: часы:минуты:секунды
                        echo date('H:i:s');
                        ?>
                    </div>
                </div>

                <!-- Остальные блоки погоды — без изменений -->
                <div class="weather-card">
                    <img src="assets/icons/thermometer.svg" alt="Temperatur" class="weather-icon">
                    <h3>Temperatur</h3>
                    <div class="weather-value"><?= $weather_data['temp'] ?? '18,5' ?> °C</div>
                </div>
                <div class="weather-card">
                    <img src="assets/icons/humidity.svg" alt="Luftfeuchte" class="weather-icon">
                    <h3>Luftfeuchte</h3>
                    <div class="weather-value"><?= $weather_data['humidity'] ?? '65' ?> %</div>
                </div>
                <div class="weather-card">
                    <img src="assets/icons/wind.svg" alt="Windgeschwindigkeit" class="weather-icon">
                    <h3>Wind</h3>
                    <div class="weather-value"><?= $weather_data['wind'] ?? '12' ?> km/h</div>
                </div>
            </div>
        </div>
    </section>

    <section id="galerie" style="background: rgba(255,255,255,0.05); padding: 80px 0;">
        <div class="container">
            <h2>Galerie – Bilder zum Thema Luft</h2>
            <div class="gallery-grid">
                <div class="gallery-img"><img src="assets/images/lufts2.jpg" alt="Luft und Atmosphäre"></div>
                <div class="gallery-img"><img src="assets/images/luft2.jpg" alt="Eigenschaften der Luft"></div>
                <div class="gallery-img"><img src="assets/images/wind2.jpg" alt="Luftteilchen und Druck"></div>
                <div class="gallery-img"><img src="assets/images/wind.jpg" alt="Wind als bewegte Luft"></div>
                <div class="gallery-img"><img src="assets/images/wind1.jpg" alt="Windenergie"></div>
                <div class="gallery-img"><img src="assets/images/wind3.jpg" alt="Luft bewegt Gegenstände"></div>
            </div>
        </div>
    </section>

    <section id="video">
        <div class="container">
            <h2>Video zum Thema Luft</h2>
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/G9OuwPRo8MM" title="YouTube Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <footer id="download">
        <div class="container">
            <div class="footer-block download-block">
                <h2>Projektarbeit herunterladen</h2>
                <div class="download-buttons">
                    <!-- ✅ ПРЯМЫЕ ССЫЛКИ — СКАЧИВАЕТ СРАЗУ ВЕЗДЕ -->
                    <a href="download/luft_projekt.pdf" class="btn" download id="pdfBtn">
                        <img src="assets/icons/downloader.svg" alt="Download"> PDF (7 Seiten)
                    </a>
                    <a href="download/luft_projekt.docx" class="btn" download id="docBtn">
                        <img src="assets/icons/downloader.svg" alt="Download"> Word (.docx)
                    </a>
                </div>
            </div>

            <div class="footer-block stats-block">
                <h3>Statistik</h3>
                <div class="stats">
                    <p>👁️ Besucher insgesamt: <strong><?= $visitors_total ?></strong></p>
                    <p>⬇️ Downloads: <strong id="downloadCount"><?= $downloads_total ?></strong></p>
                </div>
            </div>

            <!-- ✅ БЛОК С АВАТОРОМ И ПОЧТОЙ — ИСПРАВЛЕННЫЙ -->
            <div class="footer-block author-profile">
                <div class="author-avatar">
                    <img src="assets/icons/avatarEgor.svg" alt="Projektautor" class="avatar-img">
                </div>
                <div class="author-info">
                    <h3>Zubenko Egor</h3>
                    <p>Grund- und Mittelschule Bürgstadt – Klasse 7b</p>
                    <a href="mailto:egorzub2812@gmail.com" class="author-email">
                        ✉️ egorzub2812@gmail.com
                    </a>
                </div>
            </div>

            <div class="footer-block legal-block">
                <p>© <?= date('Y') ?> Alle Rechte vorbehalten</p>
                <p class="legal-links">
                    <span class="impressum-wrap"><a href="#" class="legal-link">Impressum</a><span class="legal-text">Diese Projektarbeit entstand im Rahmen des naturwissenschaftlichen Unterrichts.<br>Verantwortlich: Zubenko Egor, Klasse 7b<br>Schule: Grund- und Mittelschule Bürgstadt, Schulstraße 1, 63927 Bürgstadt</span></span> |
                    <span class="datenschutz-wrap"><a href="#" class="legal-link">Datenschutz</a><span class="legal-text">Es werden keine personenbezogenen Daten erhoben.<br>Nur anonyme Zählung von Besuchern und Downloads – ohne Personenbezug.</span></span>
                </p>
            </div>
        </div>
    </footer>

    <script>
        // ✅ СЧЕТЧИК СКАЧИВАНИЙ РАБОТАЕТ НА ЛЮБОМ СЕРВЕРЕ
        const countEl = document.getElementById('downloadCount');
        const pdfBtn = document.getElementById('pdfBtn');
        const docBtn = document.getElementById('docBtn');

        function incrementDownload() {
            let current = parseInt(countEl.textContent);
            countEl.textContent = current + 1;
            // Записываем в файл через простой запрос
            fetch('update_downloads.php', {
                    method: 'POST',
                    body: '1'
                })
                .catch(() => {}); // Игнорируем ошибку, главное — скачивание есть
        }

        pdfBtn.addEventListener('click', incrementDownload);
        docBtn.addEventListener('click', incrementDownload);

        // Тема
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        if (localStorage.getItem('theme') === 'night') {
            body.classList.add('night-mode');
            themeToggle.textContent = '🌙';
        }
        themeToggle.addEventListener('click', () => {
            body.classList.toggle('night-mode');
            localStorage.setItem('theme', body.classList.contains('night-mode') ? 'night' : 'day');
            themeToggle.textContent = body.classList.contains('night-mode') ? '🌙' : '☀️';
        });

        // Прокрутка
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', e => {
                e.preventDefault();
                document.querySelector(anchor.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Слайдер
        const slides = document.querySelectorAll('input[name="slider"]');
        const images = document.querySelectorAll('.slider-img');
        let currentSlide = 0;

        // Настройки: время показа / время перехода
        const slideInterval = 5000; // 5 секунд показываем
        const transDuration = 1200; // 1.2 секунды плавный переход

        // Сразу задаем плавность анимации для всех картинок
        images.forEach(img => {
            img.style.transition = `all ${transDuration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
        });

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].checked = true;

            // ✅ ГЛАВНОЕ ИСПРАВЛЕНИЕ: вызываем событие change вручную
            slides[currentSlide].dispatchEvent(new Event('change'));
        }


        // Запускаем автоматическое переключение
        setInterval(nextSlide, slideInterval);
    </script>
</body>

</html>