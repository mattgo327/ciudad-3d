# Ejecutar la aplicación localmente

Para ejecutar la aplicación la aplicación de forma local hay que seguir los siguientes pasos:

1. Clonar el repositorio

```bash
git clone <url repositorio>
```

2. Ejecutar desde la consola:

```bash
cd frontend
pnpm install
pnpm dev
```

Esto como resultado abrirá una solapa en [http://localhost:`5173`](http://localhost:5173).

## Entorno Producción

En el caso de realizarlo en un entorno de producción, se siguen los siguientes pasos:

1. Clonar el repositorio

```bash
git clone <url repositorio>
```

2. Ejecutar desde la consola:

```bash
cd frontend
pnpm install
```

3. Realizar el build con el siguiente comando

```bash
pnpm build
```
