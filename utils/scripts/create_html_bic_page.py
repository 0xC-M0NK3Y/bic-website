import mysql.connector
from mysql.connector import Error
from creds import DB_USER, DB_PASS, DB_NAME, DB_SERVER
import os

HTML_TEMPLATE = \
'<html lang="en" style="cursor: url(../assets/bic_orange.png),auto;" >\n' \
'<head>\n' \
'	<meta charset="UTF-8">\n' \
'	<title>BIC COLLECTION</title>\n' \
'	<link rel="icon" type="image/png" href="../favicon.png" >\n' \
'	<link rel="apple-touch-icon" type="image/png" href="../favicon.png" >\n' \
'	<link rel="apple-touch-icon-precomposed" type="image/png" href="../favicon.png" >\n' \
'	<link rel="shortcut icon" type="image/png" href="../favicon.png" >\n' \
'	<link rel="stylesheet" href="../index.css">\n' \
'</head>\n' \
'<body style="height: auto;">\n' \
'	<div class="product-item-solo">\n' \
'		<section class="product-item-inner">\n' \
'			<div class="product-item-image">\n' \
'				<img src="%s" style="border-radius: 15px;"></img>\n' \
'			</div>\n' \
'			<!-- /.product-item-image -->\n' \
'			<h1 class="product-item-title-solo">\n' \
'				%s\n' \
'			</h1>\n' \
'			<!-- /.product-item-title -->\n' \
'			<div class="product-item-infos-solo">\n' \
'				Famille: %s<br>\n' \
'				Tube: %s<br>\n' \
'				Finition du tube: %s<br>\n' \
'				Bague: %s<br>\n' \
'				Haut: %s<br>\n' \
'				Encres: %s<br>\n' \
'				Epaisseur: %s<br>\n' \
'				Prix: %s<br>\n' \
'				Rareté: %s\n' \
'				<br><br>\n' \
'				%s\n' \
'			</div>\n' \
'		</section>\n' \
'		<!-- /.product-item-inner -->\n' \
'	</div>\n' \
'</body>\n' \
'</html>\n'


def create_database_connection(hostname, username, password, db):
	connection = None
	try:
		connection = mysql.connector.connect(
			host=hostname,
			user=username,
			passwd=password,
			database=db)
	except Error as err:
		print(f"Error connecting to database: '{err}'")
	return connection

def sql_query(connection, query):
	cursor = connection.cursor()
	result = None
	try:
		cursor.execute(query)
		result = cursor.fetchall()
		return result
	except Error as err:
		print(f"Error: '{err}'")
	return None

def main():

	db_conn = create_database_connection(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
	if db_conn == None:
		return
	ids = sql_query(db_conn, 'SELECT id FROM `pen`;')

	os.mkdir("bic")
	for i in range(len(ids)):
		data = sql_query(db_conn, f'SELECT * FROM `pen` WHERE id={ids[i][0]};')
		data = data[0]
		out = open(f'bic/bic_{data[13]}.html', 'w')
		stars = ""
		imgpath = "../" + data[3].decode()
		for j in range(data[11]):
			stars += "⭐"
		comment = data[14]
		if comment == "None":
			comment = ""
		price = str(data[10])
		if price == '0.0':
			price = 'Indéterminé'
		else:
			price += " €"
		price = price.replace('.', ',')
		out.write(HTML_TEMPLATE % (imgpath, data[2], data[1], data[4], data[5], data[6], data[7], data[8], data[9], price, stars, comment))
		out.close()



if __name__ == '__main__':
	main()
