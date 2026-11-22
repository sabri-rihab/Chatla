/**
 * Chatla Automated Screenshot Generator (Playwright)
 *
 * This reusable script navigates through all primary user journeys and dashboards
 * in Chatla, capturing clean desktop screenshots into docs/screenshots/.
 *
 * Prerequisites:
 *   cd scripts && npm install
 *   npx playwright install chromium
 *
 * Execution:
 *   node scripts/screenshots.js
 */

const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

const BASE_URL = process.env.APP_URL || 'http://localhost:8000';
const OUTPUT_DIR = path.resolve(__dirname, '../docs/screenshots');
const VIEWPORT = { width: 1440, height: 900 };

async function main() {
  if (!fs.existsSync(OUTPUT_DIR)) {
    fs.mkdirSync(OUTPUT_DIR, { recursive: true });
  }

  console.log(`🌿 Launching Playwright browser targeting ${BASE_URL}...`);
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    viewport: VIEWPORT,
    deviceScaleFactor: 2,
  });

  const page = await context.newPage();

  // 1. Home Landing Page
  await page.goto(`${BASE_URL}/`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '01-home.png'), fullPage: false });
  console.log('✓ 01-home.png captured');

  // 2. Explore Botanical Catalog & Filters
  await page.goto(`${BASE_URL}/explore`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '02-explore.png'), fullPage: false });
  console.log('✓ 02-explore.png captured');

  // 3. Nurseries Directory across Morocco
  await page.goto(`${BASE_URL}/nurseries`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '03-nurseries.png'), fullPage: false });
  console.log('✓ 03-nurseries.png captured');

  // 4. Single Nursery Profile (Rozana Garden)
  await page.goto(`${BASE_URL}/nurseries/rozana-garden`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '04-nursery-detail.png'), fullPage: false });
  console.log('✓ 04-nursery-detail.png captured');

  // 5. Single Plant Care & Price Specifications
  await page.goto(`${BASE_URL}/plants/monstera-deliciosa-at-rozana-garden-1`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '05-plant-detail.png'), fullPage: false });
  console.log('✓ 05-plant-detail.png captured');

  // 6. Contact & Partnership Form
  await page.goto(`${BASE_URL}/contact`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '06-contact.png'), fullPage: false });
  console.log('✓ 06-contact.png captured');

  // 7. Login Authentication View
  await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '07-login.png'), fullPage: false });
  console.log('✓ 07-login.png captured');

  // 8. User Registration View
  await page.goto(`${BASE_URL}/register`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '08-register.png'), fullPage: false });
  console.log('✓ 08-register.png captured');

  // 9. Nursery Owner Authentication & Dashboard
  await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });
  await page.fill('input[name="email"]', 'youssef.mansouri@chatla.ma');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/dashboard', { timeout: 10000 });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '09-nursery-dashboard.png'), fullPage: false });
  console.log('✓ 09-nursery-dashboard.png captured');

  // 10. Nursery Owner Inventory Management
  await page.goto(`${BASE_URL}/nursery/plants`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '10-nursery-inventory.png'), fullPage: false });
  console.log('✓ 10-nursery-inventory.png captured');

  // 11. Add Plant to Inventory View
  await page.goto(`${BASE_URL}/nursery/plants/create`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '11-nursery-inventory-create.png'), fullPage: false });
  console.log('✓ 11-nursery-inventory-create.png captured');

  // 12. Nursery Profile Settings View
  await page.goto(`${BASE_URL}/nursery/profile`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '12-nursery-profile.png'), fullPage: false });
  console.log('✓ 12-nursery-profile.png captured');

  // 13. Admin Authentication & Management Dashboard
  await context.clearCookies();
  await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });
  await page.fill('input[name="email"]', 'admin@chatla.ma');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForURL('**/admin/dashboard', { timeout: 10000 });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '13-admin-dashboard.png'), fullPage: false });
  console.log('✓ 13-admin-dashboard.png captured');

  // 14. Admin User Requests & Moderation
  await page.goto(`${BASE_URL}/admin/requests`, { waitUntil: 'networkidle' });
  await page.screenshot({ path: path.join(OUTPUT_DIR, '14-admin-requests.png'), fullPage: false });
  console.log('✓ 14-admin-requests.png captured');

  await browser.close();
  console.log(`\n✨ All 14 screenshots successfully saved to docs/screenshots/`);
}

main().catch((err) => {
  console.error('Screenshot generation encountered an error:', err);
  process.exit(1);
});
