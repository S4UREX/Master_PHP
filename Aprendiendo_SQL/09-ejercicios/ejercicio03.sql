/**
  3. Incrementar el precio de los coches en un 2%
 */

 SELECT * FROM coches;

UPDATE coches SET precio = ((precio * 0.02) + precio);