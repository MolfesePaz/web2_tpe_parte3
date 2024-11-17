# web2_tpe_entrega3

# Endpoints
Usar paginado y orderBy de manera descendente:
http://localhost/web2_tpe_parte3/api/viajes?limit=4&orderBy=id&orderDir=DESC

De manera ascendente con paginado:
http://localhost/web2_tpe_parte3/api/viajes?limit=4&orderBy=id&orderDir=ASC

El item a aplicar el orderBy puede ser cualquiera de la tabala como: 

-id,

-origen,

-destino,

-FechaDeSalida,

-FechaDeLlegada.

Get: /viajes
http://localhost/web2_tpe_parte3/api/viajes.
Por default se va a ordenar de manera ascendente, al menos que el orden se cambie.

# Importar la base de datos
Importar el archivo viajeslupa.sql dentro de PHPMyAdmin para tener la base de datos completa.

recordar que esta entrega la hice sola, por eso solo esta implementado el put, aunque agregue la busqueda de un item por id o detalle por utilidad.
