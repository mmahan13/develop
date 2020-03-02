import {erp} from '../app.js';
erp.service('exportXlsx', ['FileSaver',
    function (FileSaver) {
    
    this.exportXlsxFile = function (JSONCollection, fileName, SheetName) {
        function getKeys(object) {
            return Object.keys(object[0]);
        }

        function datenum(v, date1904) {
            if (date1904) v += 1462;
            const epoch = Date(v);
            return (epoch - new Date(Date.UTC(1899, 11, 30))) / (24 * 60 * 60 * 1000);
        }

        function sheet_from_array_of_arrays(data, opts) {
            let ws = {};
            let range = {
                s: {
                    c: 10000000,
                    r: 10000000
                },
                e: {
                    c: 0,
                    r: 0
                }
            };
            for (let R = 0; R != data.length; ++R) {
                for (let C = 0; C != data[R].length; ++C) {
                    if (range.s.r > R) range.s.r = R;
                    if (range.s.c > C) range.s.c = C;
                    if (range.e.r < R) range.e.r = R;
                    if (range.e.c < C) range.e.c = C;
                    let cell = {
                        v: data[R][C]
                    };
                    if (cell.v == null) continue;
                    let cell_ref = XLSX.utils.encode_cell({
                        c: C,
                        r: R
                    });

                    if (typeof cell.v === 'number') cell.t = 'n';
                    else if (typeof cell.v === 'boolean') cell.t = 'b';
                    else if (cell.v instanceof Date) {
                        cell.t = 'n';
                        cell.z = XLSX.SSF._table[14];
                        cell.v = datenum(cell.v);
                    } else cell.t = 's';

                    ws[cell_ref] = cell;
                }
            }
            if (range.s.c < 10000000) ws['!ref'] = XLSX.utils.encode_range(range);
            return ws;
        }

        /* original data */
        let data = [];
        data.push(getKeys(JSONCollection));
        $.each(JSONCollection, function (i, o) {
            data.push($.map(o, function (el) {
                return el == null ? '' : el;
            }));
        });
        const ws_name = SheetName ? SheetName : 'Hoja1';
        const FileName = fileName ? fileName : new Date();

        function Workbook() {
            if (!(this instanceof Workbook)) return new Workbook();
            this.SheetNames = [];
            this.Sheets = {};
        }

        let wb = new Workbook(),
            ws = sheet_from_array_of_arrays(data);

        /* add worksheet to workbook */
        wb.SheetNames.push(ws_name);
        wb.Sheets[ws_name] = ws;
        let wbout = XLSX.write(wb, {
            bookType: 'xlsx',
            bookSST: true,
            type: 'binary'
        });

        function s2ab(s) {
            const buf = new ArrayBuffer(s.length);
            const view = new Uint8Array(buf);
            for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }

        FileSaver.saveAs(new Blob([s2ab(wbout)], {
            type: 'application/octet-stream'
        }), FileName + '.xlsx');
    };
}]);