/**
 * Autocompletado tipo Simit: pegar un bloque de texto (cotización, Excel, correo, etc.)
 * y rellenar el formulario de cliente/vehículo/póliza sin guardar.
 */

function stripAccents(s) {
    return String(s).normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

function normalizeKey(s) {
    let out = String(s)
        .replace(/\uFEFF/g, '')
        .replace(/[\u00A0\u2000-\u200B\u202F\u205F\u3000]/g, ' ');
    out = stripAccents(out)
        .toLowerCase()
        .replace(/^\*+\s*/, '')
        .replace(/\s+/g, ' ')
        .trim();
    out = out.replace(/[:.;,]+$/g, '').trim();
    return out;
}

/** PDF/correo: \r suelto, separadores Unicode, etc. */
function splitLines(text) {
    return String(text || '').split(/\r\n|\n|\r|\u2028|\u2029/).map((l) => l.replace(/\uFEFF/g, '').trim());
}

function parseDateToHtmlInput(str) {
    if (!str) return '';
    const t = String(str).trim();
    if (/^\d{4}-\d{2}-\d{2}$/.test(t)) return t;
    const m = t.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
    if (m) {
        const d = m[1].padStart(2, '0');
        const mo = m[2].padStart(2, '0');
        const y = m[3];
        return `${y}-${mo}-${d}`;
    }
    return '';
}

function parseMoney(str) {
    if (!str) return '';
    let s = String(str).replace(/[^\d.,\-]/g, '').trim();
    if (!s) return '';
    const lastComma = s.lastIndexOf(',');
    const lastDot = s.lastIndexOf('.');
    if (lastComma > lastDot) {
        s = s.replace(/\./g, '').replace(',', '.');
    } else {
        s = s.replace(/,/g, '');
    }
    return s;
}

function mapTipoDocumento(v) {
    const x = stripAccents(String(v).toUpperCase()).replace(/\s+/g, ' ').trim();
    if (!x) return '';
    if (x === 'CC' || x === 'C.C' || x === 'C.C.' || x.startsWith('C.C ')) return 'CC';
    if (x === 'CE') return 'CE';
    if (x === 'PA') return 'PA';
    if (x === 'NIT') return 'NIT';
    if (x.includes('NIT')) return 'NIT';
    if (x.includes('PASAPORTE')) return 'PA';
    if (x.includes('EXTRANJER') || x.includes('EXTRANJERIA') || x.includes('EXTRANJERÍA')) return 'CE';
    if (x.includes('CEDULA') || x.includes('CIUDADAN') || x.includes('CIUDADANIA')) return 'CC';
    if (x.includes('TARJETA') && x.includes('IDENTIDAD')) return 'CC';
    if (x.includes('REGISTRO') && x.includes('CIVIL')) return 'CC';
    return '';
}

function mapTipoVehiculo(v) {
    const x = stripAccents(v).toUpperCase().replace(/\s+/g, ' ').trim().replace(/_/g, ' ');
    const keys = [
        'MOTOCICLETA', 'AUTOMOVIL', 'CAMPERO', 'CAMIONETA', 'CARGA',
        'MOTOCARRO', 'SERVICIO_PUBLICO', 'OTRO',
    ];
    for (let k = 0; k < keys.length; k += 1) {
        const key = keys[k];
        const keySpaced = key.replace(/_/g, ' ');
        if (x === key || x === keySpaced) return key;
    }
    if (x.includes('MOTOCARRO')) return 'MOTOCARRO';
    if (x.includes('MOTOCICL') || x === 'MOTO') return 'MOTOCICLETA';
    if (x.includes('SERVICIO') && x.includes('PUBLIC')) return 'SERVICIO_PUBLICO';
    if (x.includes('CAMIONETA')) return 'CAMIONETA';
    if (x.includes('CAMPERO')) return 'CAMPERO';
    if (x.includes('AUTOMOV') || x === 'AUTO') return 'AUTOMOVIL';
    if (x.includes('CARGA')) return 'CARGA';
    return 'OTRO';
}

function mapEstado(v) {
    const n = normalizeKey(v);
    if (n.includes('vigent')) return 'vigente';
    if (n.includes('vencid')) return 'vencida';
    if (n.includes('proxim')) return 'proxima_vencer';
    return '';
}

/**
 * Etiqueta sola en una línea y valor en la línea siguiente (formato cotización SOAT).
 */
function standaloneLabelToField(line) {
    const raw = String(line).trim();
    if (!raw || raw.startsWith('*')) return null;
    if (raw.length > 100 && raw.includes('Seguros Mundial')) return null;

    const n = normalizeKey(raw);
    if (
        n === 'datos del propietario'
        || n === 'datos del vehiculo'
        || n === 'datos de la poliza'
        || n.startsWith('datos del ')
        || n.startsWith('datos de la ')
    ) {
        return null;
    }

    const map = {
        placa: 'placa',
        linea: 'linea',
        marca: 'marca',
        modelo: '_modelo',
        clase: 'clase',
        'tipo de vehiculo': 'tipo_vehiculo',
        nombres: 'nombre',
        apellidos: 'apellidos',
        identificacion: 'numero_documento',
        'no. identificacion': 'numero_documento',
        'no identificacion': 'numero_documento',
        'numero identificacion': 'numero_documento',
        'nro. identificacion': 'numero_documento',
        'nro identificacion': 'numero_documento',
        cedula: 'numero_documento',
        'numero de documento': 'numero_documento',
        'numero documento': 'numero_documento',
        'nro. documento': 'numero_documento',
        'nro documento': 'numero_documento',
        'no. documento': 'numero_documento',
        'no documento': 'numero_documento',
        'tipo de documento': 'tipo_documento',
        'numero de poliza': 'numero_poliza',
        'numero poliza': 'numero_poliza',
        poliza: 'numero_poliza',
        'fecha de inicio': 'fecha_inicio',
        'fecha inicio': 'fecha_inicio',
        'fecha de fin': 'fecha_fin',
        'fecha fin': 'fecha_fin',
        valor: 'valor',
        prima: 'valor',
        estado: 'estado',
        aseguradora: 'aseguradora',
    };

    if (map[n]) return map[n];
    if (
        (n.includes('numero') || n.includes('nro'))
        && n.includes('documento')
        && !n.includes('tipo')
    ) {
        return 'numero_documento';
    }
    return null;
}

function parseTwoLinePairs(text, pairs) {
    const lines = splitLines(text);

    for (let i = 0; i < lines.length; i += 1) {
        const line = lines[i];
        if (!line || line.startsWith('*')) continue;

        const field = standaloneLabelToField(line);
        if (!field) continue;

        let j = i + 1;
        while (j < lines.length && lines[j] === '') j += 1;
        if (j >= lines.length) continue;

        const value = lines[j];
        if (!value || value.startsWith('*')) continue;
        if (standaloneLabelToField(value)) continue;

        pairs[field] = value;
        i = j;
    }
}

function labelToField(label) {
    const n = normalizeKey(label);
    const nAscii = stripAccents(n);

    if (n.includes('fecha') && n.includes('inicio')) return 'fecha_inicio';
    if (n.includes('fecha') && n.includes('fin')) return 'fecha_fin';

    if (nAscii.includes('numero') && nAscii.includes('poliza')) return 'numero_poliza';
    if ((n === 'poliza' || n.startsWith('poliza')) && !n.includes('fecha')) return 'numero_poliza';

    if (n.includes('tipo') && (n.includes('documento') || n.includes('identificaci'))) return 'tipo_documento';

    const docNumLabel = (n.includes('documento') || n.includes('identificaci') || n.includes('cedula'))
        && !n.includes('vehiculo')
        && !n.includes('tipo');
    if (docNumLabel) {
        if (
            n.includes('numero')
            || n.includes('nro')
            || n.includes('nº')
            || n.includes('n°')
            || /^no\.?\s/.test(n)
            || n.startsWith('no ')
            || n === 'identificacion'
            || n.endsWith(' identificacion')
        ) {
            return 'numero_documento';
        }
    }
    if (n.includes('documento') && !n.includes('tipo') && !n.includes('vehiculo')) return 'numero_documento';

    if (n.includes('tipo') && n.includes('vehiculo')) return 'tipo_vehiculo';

    if (n.includes('apellido')) return 'apellidos';
    if (n.includes('nombre') && !n.includes('numero')) return 'nombre';

    if (n.includes('linea')) return 'linea';
    if (n.includes('marca')) return 'marca';
    if (n.includes('clase')) return 'clase';

    if (n.includes('modelo')) return '_modelo';
    if (n === 'ano' || n === 'año' || (n.includes('año') && !n.includes('vehiculo'))) return 'año';

    if (n.includes('placa')) return 'placa';

    if (n === 'nit' || (n.includes('nit') && (n.includes('numero') || n.includes('nro')))) {
        return 'numero_documento';
    }
    if (
        n === 'cedula'
        || n === 'c.c.'
        || n === 'c.c'
        || n === 'cc'
        || (n.startsWith('cedula ') && !n.includes('extranjer'))
    ) {
        return 'numero_documento';
    }

    if (n.includes('aseguradora')) return 'aseguradora';
    if (n.includes('valor') || n.includes('prima')) return 'valor';
    if (n === 'estado' || (n.includes('estado') && !nAscii.includes('poliza'))) return 'estado';

    return null;
}

function sanitizeNumeroDocumento(v) {
    let s = String(v).trim();
    if (!s) return s;
    const digits = s.replace(/\D/g, '');
    if (digits.length >= 6 && digits.length <= 12 && !s.includes('-')) {
        return digits;
    }
    if (/^[\d.\-\s]+$/.test(s) && (s.includes('-') || digits.length > 10)) {
        return s.replace(/\s+/g, '');
    }
    return s;
}

/**
 * Si en el texto aparece tipo (CC/CE/PA/NIT) junto a un número largo, rellena pares faltantes.
 */
function extractDocumentPairsFromText(text, pairs) {
    const t = String(text);
    if (!pairs.numero_documento || !pairs.tipo_documento) {
        const re = /\b(CC|CE|PA|NIT)\b\s*[:\-]?\s*([\d.]{5,20})\b/gi;
        let m = re.exec(t);
        while (m) {
            const tipo = m[1].toUpperCase();
            const rawNum = m[2].replace(/\./g, '');
            if (/^\d{6,12}$/.test(rawNum)) {
                if (!pairs.tipo_documento) pairs.tipo_documento = tipo;
                if (!pairs.numero_documento) pairs.numero_documento = rawNum;
                break;
            }
            m = re.exec(t);
        }
    }
    if (!pairs.numero_documento) {
        const m2 = t.match(
            /(?:cedula|identificaci[oó]n|c\.?\s*c\.?)\s*(?:no\.?|n[°º]\s*|n[uú]mero\s*)?[.:]?\s*([\d.\s]{6,20}\d)/i
        );
        if (m2) {
            const raw = m2[1].replace(/[^\d]/g, '');
            if (raw.length >= 6 && raw.length <= 12) {
                pairs.numero_documento = raw;
            }
        }
    }
}

function setSelectByValue(select, rawValue, name) {
    let code = String(rawValue).trim();
    if (!code) return false;
    const rawTipoDoc = name === 'tipo_documento' ? code : '';
    if (name === 'tipo_vehiculo') {
        code = mapTipoVehiculo(code);
    }
    if (name === 'tipo_documento') {
        const m = mapTipoDocumento(code);
        if (m) code = m;
    }

    const opts = Array.from(select.options);
    const codeNorm = stripAccents(code).toUpperCase();

    let hit = opts.find((o) => o.value === code);
    if (!hit) hit = opts.find((o) => stripAccents(o.value).toUpperCase() === codeNorm);
    if (!hit) {
        hit = opts.find(
            (o) => stripAccents(o.text).toUpperCase().replace(/\s+/g, ' ') === codeNorm.replace(/_/g, ' ')
        );
    }
    if (!hit && name === 'tipo_vehiculo') {
        hit = opts.find((o) => mapTipoVehiculo(o.text) === code);
    }
    if (!hit && name === 'tipo_documento') {
        const want = mapTipoDocumento(rawTipoDoc) || code;
        if (want && ['CC', 'CE', 'PA', 'NIT'].includes(want)) {
            hit = opts.find((o) => o.value === want);
        }
        if (!hit && want) {
            hit = opts.find((o) => mapTipoDocumento(o.text) === want);
        }
    }

    if (hit && hit.value !== '') {
        select.value = hit.value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        select.dispatchEvent(new Event('input', { bubbles: true }));
        return true;
    }
    return false;
}

function setField(form, name, value) {
    if (value === null || value === undefined || String(value).trim() === '') return;
    const el = form.querySelector('[name="' + name.replace(/"/g, '') + '"]');
    if (!el) return;

    if (el.tagName === 'SELECT') {
        setSelectByValue(el, value, name);
        return;
    }

    el.value = value;
    if (name === 'placa' && el.getAttribute('data-upper') !== null) {
        el.value = String(value).toUpperCase();
    }
}

/**
 * @param {HTMLFormElement|null} form
 * @param {HTMLTextAreaElement|null} textarea
 */
function procesarTextoSoatRegistro(form, textarea) {
    const f = form || document.getElementById('cliente-soat-form');
    const ta = textarea || document.getElementById('soat-paste-bloque');
    if (!f || !ta) {
        console.warn('SOAT autofill: formulario o área de pegado no encontrados.');
        return;
    }

    const raw = ta.value || '';
    if (!raw.trim()) {
        window.alert('Pega primero el texto con los datos (Placa, Marca, Nombres, etc.).');
        return;
    }

    const linesArr = splitLines(raw);
    const text = linesArr.join('\n');
    const pairs = {};

    parseTwoLinePairs(text, pairs);

    const lineRe = /^([^:|\t]+)[:|\t]\s*(.+)$/;
    linesArr.forEach((line) => {
        const m = line.trim().match(lineRe);
        if (m) {
            const field = labelToField(m[1]);
            if (field) {
                pairs[field] = m[2].trim();
            }
        }
    });

    // Regex útiles sobre el texto completo (placa suelta, etc.)
    const placaLoose = text.match(/\bPlaca\s*[:#]?\s*([A-Z0-9]{5,10})\b/i);
    if (placaLoose && !pairs.placa) {
        pairs.placa = placaLoose[1].toUpperCase();
    }

    extractDocumentPairsFromText(text, pairs);

    Object.keys(pairs).forEach((key) => {
        if (key === '_modelo') {
            const val = pairs._modelo;
            if (/^\d{4}$/.test(val)) {
                setField(f, 'año', val);
            } else {
                const lineaEl = f.querySelector('[name="linea"]');
                if (lineaEl && !String(lineaEl.value).trim()) {
                    setField(f, 'linea', val);
                }
            }
            return;
        }

        if (key === 'tipo_documento') {
            setField(f, 'tipo_documento', pairs[key]);
            return;
        }

        if (key === 'numero_documento') {
            setField(f, 'numero_documento', sanitizeNumeroDocumento(pairs[key]));
            return;
        }

        if (key === 'tipo_vehiculo') {
            setField(f, 'tipo_vehiculo', pairs[key]);
            return;
        }

        if (key === 'estado') {
            const e = mapEstado(pairs[key]);
            if (e) setField(f, 'estado', e);
            return;
        }

        if (key === 'fecha_inicio' || key === 'fecha_fin') {
            const d = parseDateToHtmlInput(pairs[key]);
            if (d) setField(f, key, d);
            return;
        }

        if (key === 'valor') {
            const v = parseMoney(pairs[key]);
            if (v !== '') setField(f, 'valor', v);
            return;
        }

        if (key === 'placa') {
            setField(f, 'placa', String(pairs[key]).toUpperCase());
            return;
        }

        setField(f, key, pairs[key]);
    });

    const tipoDocEl = f.querySelector('[name="tipo_documento"]');
    if (tipoDocEl && !String(tipoDocEl.value || '').trim()) {
        setField(f, 'tipo_documento', 'CC');
    }

    const tipoVehSel = f.querySelector('[name="tipo_vehiculo"]');
    if (tipoVehSel && !String(tipoVehSel.value || '').trim() && pairs.clase) {
        setField(f, 'tipo_vehiculo', pairs.clase);
    }

    window.alert('Texto procesado. Revisa los campos antes de guardar.');
}

window.procesarTextoSoatRegistro = function () {
    procesarTextoSoatRegistro(null, null);
};
