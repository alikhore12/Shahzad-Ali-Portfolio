import fs from 'fs';

try {
    if (!fs.existsSync('dist')) {
        fs.mkdirSync('dist', { recursive: true });
    }
    if (fs.existsSync('storage/app/public')) {
        fs.cpSync('storage/app/public', 'public/storage', { recursive: true });
        fs.cpSync('storage/app/public', 'dist/storage', { recursive: true });
        console.log('✓ storage/app/public copied to public/storage and dist/storage');
    }
    if (fs.existsSync('public')) {
        fs.cpSync('public', 'dist', { recursive: true });
    }
    console.log('✓ dist directory prepared successfully for Vercel.');
} catch (e) {
    console.warn('Warning preparing dist directory:', e.message);
}
