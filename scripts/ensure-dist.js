import fs from 'fs';

try {
    if (!fs.existsSync('dist')) {
        fs.mkdirSync('dist', { recursive: true });
    }
    if (fs.existsSync('public')) {
        fs.cpSync('public', 'dist', { recursive: true });
    }
    console.log('✓ dist directory prepared successfully for Vercel.');
} catch (e) {
    console.warn('Warning preparing dist directory:', e.message);
}
