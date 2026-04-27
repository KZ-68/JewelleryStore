import sharp from 'sharp';
import { readdir } from 'fs/promises';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const heroDir = path.join(__dirname, '../public/storage/img/hero');

const images = [
    'Hero_Chinese_New_Year_2026.png',
    'Hero_Test_Image_1.png',
    'Hero_Test_Image_2.png',
];

for (const filename of images) {
    const input = path.join(heroDir, filename);
    const base = filename.replace(/\.png$/, '');

    const desktopOut = path.join(heroDir, `${base}.webp`);
    await sharp(input)
        .resize(1920, 600, { fit: 'cover' })
        .webp({ quality: 85 })
        .toFile(desktopOut);

    const { size: ds } = await sharp(desktopOut).metadata();
    console.log(`✓ ${base}.webp`);

    const mobileOut = path.join(heroDir, `${base}_mobile.webp`);
    await sharp(input)
        .resize(768, 240, { fit: 'cover' })
        .webp({ quality: 80 })
        .toFile(mobileOut);

    console.log(`✓ ${base}_mobile.webp`);
}

console.log('\nConversion terminée.');
