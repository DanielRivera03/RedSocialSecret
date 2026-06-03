<?php
/*
--------------------------------------------------------
║            SECRET - RED SOCIAL PHP NATIVO            ║
    HELPER: Seguridad Inteligente
    - Detección de Dispositivos (OS, Browser)
    - Geolocalización de IP dinámica
    - Análisis inteligente de nivel de riesgo
--------------------------------------------------------
*/

class HelperSeguridad {
    
    /**
     * Parsea la cadena User-Agent para extraer OS y Navegador legibles.
     */
    public static function parseUserAgent($ua) {
        $os = 'Sistema Operativo Desconocido';
        $browser = 'Navegador Desconocido';

        if (empty($ua)) {
            return ['os' => $os, 'browser' => $browser];
        }

        // Detectar OS
        if (preg_match('/windows|win32/i', $ua)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $os = 'macOS';
        } elseif (preg_match('/android/i', $ua)) {
            $os = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $ua)) {
            $os = 'iOS';
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
        }

        // Detectar Navegador
        if (preg_match('/msie/i', $ua) && !preg_match('/opera/i', $ua)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/firefox/i', $ua)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/chrome/i', $ua) && !preg_match('/edge|edg/i', $ua)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/safari/i', $ua) && !preg_match('/chrome/i', $ua)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/edge|edg/i', $ua)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/opera|opr/i', $ua)) {
            $browser = 'Opera';
        }

        return ['os' => $os, 'browser' => $browser];
    }

    /**
     * Consulta una API de geolocalización pública para obtener la ubicación de la IP.
     * Soporta mocks en redes locales / localhost.
     */
    public static function getIpLocation($ip) {
        // Ignorar rangos locales para evitar peticiones fallidas y lentitud en desarrollo
        if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0 || strpos($ip, '172.') === 0) {
            return [
                'city' => 'San Salvador',
                'country' => 'El Salvador',
                'isp' => 'Red Local / Desarrollo Local'
            ];
        }

        $url = "http://ip-api.com/json/" . urlencode($ip);
        // Timeout de 2 segundos para no demorar la experiencia del usuario
        $ctx = stream_context_create(['http' => ['timeout' => 2]]);
        $json = @file_get_contents($url, false, $ctx);
        if ($json) {
            $data = json_decode($json, true);
            if (isset($data['status']) && $data['status'] === 'success') {
                return [
                    'city' => $data['city'] ?? 'Desconocida',
                    'country' => $data['country'] ?? 'Desconocido',
                    'isp' => $data['isp'] ?? 'Desconocido'
                ];
            }
        }

        return [
            'city' => 'Desconocida',
            'country' => 'Desconocido',
            'isp' => 'Proveedor Desconocido'
        ];
    }

    /**
     * Genera un reporte inteligente de evaluación de riesgos comparando logins.
     */
    public static function getSecurityReport($prevOS, $currOS, $prevBrowser, $currBrowser, $prevIP, $currIP, $prevLoc, $currLoc) {
        $threatLevel = 'BAJO';
        $reasons = [];

        if ($prevOS !== $currOS && $prevOS !== null) {
            $threatLevel = 'MEDIO';
            $reasons[] = "Cambio de sistema operativo (de <strong>$prevOS</strong> a <strong>$currOS</strong>).";
        }
        if ($prevBrowser !== $currBrowser && $prevBrowser !== null) {
            $reasons[] = "Cambio de navegador web (de <strong>$prevBrowser</strong> a <strong>$currBrowser</strong>).";
        }
        if ($prevIP !== $currIP && $prevIP !== null) {
            if ($prevLoc['city'] !== $currLoc['city'] || $prevLoc['country'] !== $currLoc['country']) {
                $threatLevel = 'ALTO';
                $reasons[] = "Acceso desde una ubicación geográfica inusual (de <strong>" . $prevLoc['city'] . ", " . $prevLoc['country'] . "</strong> a <strong>" . $currLoc['city'] . ", " . $currLoc['country'] . "</strong>).";
            } else {
                if ($threatLevel === 'BAJO') {
                    $threatLevel = 'MEDIO';
                }
                $reasons[] = "Cambio de dirección IP en la misma ciudad (de <strong>$prevIP</strong> a <strong>$currIP</strong>).";
            }
        }

        $assessment = "";
        if (empty($reasons)) {
            $assessment = "Este inicio de sesión coincide plenamente con tus patrones de comportamiento habituales.";
        } else {
            $assessment = "Nuestros algoritmos inteligentes de seguridad han clasificado esta actividad con un nivel de sospecha <strong>$threatLevel</strong> debido a las siguientes anomalías:<br><br>";
            foreach ($reasons as $r) {
                $assessment .= "• $r<br>";
            }
        }

        return [
            'level' => $threatLevel,
            'reasons' => $reasons,
            'assessment' => $assessment
        ];
    }
}
?>
