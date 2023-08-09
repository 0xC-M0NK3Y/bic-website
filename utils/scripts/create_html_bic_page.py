import mysql.connector
from mysql.connector import Error
import os

HTML_TEMPLATE = \
'<html lang="en">' \
'<head>' \
'	<meta charset="UTF-8">' \
'	<link rel="stylesheet" href="../index.css">' \
'</head>' \
'<body>' \
'	<div class="product-item-solo">' \
'		<section class="product-item-inner">' \
'			<div class="product-item-image">' \
'				<img width="50" height="350" src="%s"></img>' \
'			</div>' \
'			<!-- /.product-item-image -->' \
'			<h1 class="product-item-title">' \
'				%s' \
'			</h1>' \
'			<!-- /.product-item-title -->' \
'			<div class="product-item-infos">' \
'				Couleur du tube: %s<br>' \
'				Finition du tube: %s<br>' \
'				Couleur de la bague: %s<br>' \
'				Haut: %s<br>' \
'				Couleur des encres: %s<br>' \
'				Epaisseur: %s<br>' \
'				Prix: %s€<br>' \
'				Rareté: %s' \
'			</div>' \
'			<div class="product-item-lower">' \
'				<div class="product-item-short-description">' \
'					%s' \
'				</div>' \
'			<br><br><br>' \
'			</div>' \
'		</section>' \
'		<!-- /.product-item-inner -->' \
'	</li>' \
'</body>' \
'</html>'


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

	db_conn = create_database_connection('localhost', 'bic_user', 'bic_user', 'bic_db')
	if db_conn == None:
		return
	number = int(sql_query(db_conn, 'SELECT COUNT(id) FROM `pen`;')[0][0])

	os.mkdir("bic")
	for i in range(number):
		data = sql_query(db_conn, f'SELECT * FROM `pen` WHERE id={i+1};')
		data = data[0]
		out = open(f'bic/bic_{i+1}.html', 'w')
		stars = ""
		imgpath = "../" + data[3].decode()
		for j in range(data[11]):
			stars += "⭐"
		comment = data[12]
		if comment == "None":
			comment = ""
		out.write(HTML_TEMPLATE % (imgpath, data[2], data[4], data[5], data[6], data[7], data[8], data[9], str(data[10]), stars, comment))
		out.close()



if __name__ == '__main__':
	main()
