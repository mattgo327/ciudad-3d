<h1>CDE 3D</h1>

## Descripción del proyecto

Este proyecto tiene como objetivo mostrar de forma interactiva información sobre las edificaciones en Ciudad del Este. Actualmente la aplicación abarca el centro comercial [Plaza City](https://plaza-city.com/).

La API proporciona acceso a datos sobre cada parcela.

### Tecnologías usadas

La página web está desarrollada con el framework [SvelteKit](https://kit.svelte.dev/) y utilizamos [CSS Tailwind](https://tailwindcss.com/) para estilizar la interfaz de usuario. Además, hemos utilizado la librería [Leaflet](https://leafletjs.com/) para mostrar y dar funcionalidad al mapa junto a los modelos 3D que provienen de [OSM Buildings](https://osmbuildings.org/). Para el despliegue se utiliza el servicio de [Vercel](https://vercel.com/).

## API

Dirección:

Los endpoints disponibles son:

- GET `/parcel`: Devuelve la información sobre la parcela
