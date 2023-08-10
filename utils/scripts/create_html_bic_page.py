import mysql.connector
from mysql.connector import Error
import os

HTML_TEMPLATE = \
'<html lang="en">\n' \
'<head>\n' \
'	<meta charset="UTF-8">\n' \
'	<link rel="stylesheet" href="../index.css">\n' \
'</head>\n' \
'<body>\n' \
'	<div class="product-item-solo">\n' \
'		<section class="product-item-inner">\n' \
'			<div class="product-item-image">\n' \
'				<img src="%s" style="border-radius: 20px;"></img>\n' \
'			</div>\n' \
'			<!-- /.product-item-image -->\n' \
'			<h1 class="product-item-title-solo">\n' \
'				%s\n' \
'			</h1>\n' \
'			<!-- /.product-item-title -->\n' \
'			<div class="product-item-infos-solo">\n' \
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
		comment = data[13]
		if comment == "None":
			comment = ""
		price = str(data[10])
		if price == '0.0':
			price = 'Indeterminé'
		else:
			price += " €"
		price = price.replace('.', ',')
		out.write(HTML_TEMPLATE % (imgpath, data[2], data[4], data[5], data[6], data[7], data[8], data[9], price, stars, comment))
		out.close()



if __name__ == '__main__':
	main()
