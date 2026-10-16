import fs from 'fs';

try {
    if (!fs.existsSync('dist')) {
        fs.mkdirSync('dist', { recursive: true });
    }
    if (fs.existsSync('storage/app/public')) {
        try {
            if (!fs.existsSync('public/storage')) {
                fs.cpSync('storage/app/public', 'public/storage', { recursive: true });
            }
        } catch (_) {}
        try {
            fs.cpSync('storage/app/public', 'dist/storage', { recursive: true });
        } catch (_) {}
        console.log('✓ storage/app/public prepared for public and dist');
    }
    if (fs.existsSync('public')) {
        fs.cpSync('public', 'dist', { recursive: true });
    }
    console.log('✓ dist directory prepared successfully for Vercel.');
} catch (e) {
    console.warn('Warning preparing dist directory:', e.message);
}
