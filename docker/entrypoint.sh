
set -e

composer install --no-interaction --prefer-dist

if [ ! -f .env ]; then
  echo "*** Création du .env ***"
  cp .env.example .env
fi

echo "*** Génération de la clé APP_KEY ***"
php artisan key:generate --force

echo "*** Installation des dependances front ***"
npm install

echo "*** Build des assets Vite ***"
npm run build

echo "*** Lancement des migration ***"
php artisan migrate --force

echo "*** Démarrage de Laravel ***"
exec php artisan serve --host=0.0.0.0 --port=8000
