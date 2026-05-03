const https = require('https');
const fs = require('fs');

const plants = [
    "Monstera_deliciosa", "Philodendron_Imperial_Green", "Epipremnum_aureum", 
    "Spathiphyllum", "Opuntia", "Cereus_peruvianus", "Rosa_damascena", "Prunus_persica", 
    "Lavandula", "Mentha_spicata", "Helianthus_annuus", "Calendula_officinalis", 
    "Ceratonia_siliqua", "Acacia", "Phalaenopsis", "Euphorbia_pulcherrima", 
    "Ficus_benjamina", "Ficus_carica", "Citrus_sinensis", "Citrus_limon", 
    "Nerium_oleander", "Plumeria_rubra", "Phoenix_dactylifera", "Chamaerops_humilis", 
    "Ananas_comosus", "Eucalyptus", "Myrtus_communis"
];

const getImages = (plant) => {
    return new Promise((resolve) => {
        const url = `https://en.wikipedia.org/w/api.php?action=query&generator=search&gsrsearch=${plant}&gsrnamespace=6&gsrlimit=10&prop=imageinfo&iiprop=url&format=json`;
        https.get(url, { headers: { 'User-Agent': 'Mozilla/5.0' } }, (res) => {
            let data = '';
            res.on('data', chunk => data += chunk);
            res.on('end', () => {
                try {
                    const json = JSON.parse(data);
                    const pages = json.query?.pages || {};
                    let urls = [];
                    Object.values(pages).forEach(page => {
                        const imgUrl = page.imageinfo?.[0]?.url;
                        // filter out svg, pdf, ogg
                        if (imgUrl && !imgUrl.endsWith('.svg') && !imgUrl.endsWith('.pdf') && !imgUrl.endsWith('.ogg')) {
                            urls.push(imgUrl);
                        }
                    });
                    resolve(urls.slice(0, 5));
                } catch(e) {
                    resolve([]);
                }
            });
        }).on('error', () => resolve([]));
    });
};

(async () => {
    let result = {};
    for (let i = 0; i < plants.length; i++) {
        const urls = await getImages(plants[i]);
        result[i+1] = urls;
        console.log(`Fetched ${urls.length} for ${plants[i]}`);
    }
    fs.writeFileSync('images_output.json', JSON.stringify(result, null, 2));
})();
