# Prueba técnica Backend

- Usa Symfony para el desarrollo.
- Es imprescindible el uso de Git como control de versiones, la entrega será el acceso al repositorio, alojado en Github, Gitlab o Bitbucket.
- Se valorará toda buena práctica, patrones y metodologías aplicadas para que el código sea mantenible en el tiempo.
- Buscamos una solución de la que estés orgulloso.
- Si no tienes tiempo para implementar features “extras”, puedes detallarlas en el README a modo de Roadmap para una solución más completa.

### Implementa una API con un solo endpoint siguiendo la siguiente definición

POST `/api/v1/short-urls`

- Recibe un body con los siguiente requisitos:

```html
url: string, required
```

- Devuelve un objeto JSON con la siguiente estructura:

```json
{
	"url": "https://example.com/12345"
}
```

El parámetro post URL ha de ser una URL larga con o sin parámetros añadidos (ejemplo: https://www.google.es/search?sca_esv=3c0cd88929cc7700&q=gatos+en+el+espacio&tbm=isch&source=lnms&sa=X&ved=2ahUKEwivkLnlseyEAxWRUaQEHU9sAgYQ0pQJegQICRAB&biw=1728&bih=959&dpr=2) y ha de devolver una URL acortada que haga un redirect a dicha URL.

Utiliza una API pública a tu elección, recomendamos tinyurl con su API: `GET https://tinyurl.com/api-create.php?url=http://www.example.com`

Si dejas el código preparado para poder optar por otra API pública (por si TinyURL cierra), mejor que mejor.

### Autorización

La autorización será tipo "Bearer Token", por ejemplo: `Authorization: Bearer my-token`.

Cualquier token que cumpla con el problema de los paréntesis (descrito a continuación) es un token válido, por ejemplo: `Authorization: Bearer []{}`

### Problema de los paréntesis

Dada una cadena que contiene tan solo los caracteres `{`, `}`, `[`, `]`, `(` y `)` determina si la entrada es válida.

La entrada es válida si cumple las siguientes condiciones:

- Los paréntesis/llaves/corchetes abiertos se deben cerrar con el mismo tipo.
- Los paréntesis/llaves/corchetes abiertos se deben cerrar en el orden correcto.

Ejemplos:

- `{}` - `true`
- `{}[]()` - `true`
- `{)` - `false`
- `[{]}` - `false`
- `{([])}` - `true`
- `(((((((()` - `false`
