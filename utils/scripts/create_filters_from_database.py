import mysql.connector
from mysql.connector import Error
from index_php import *
import sys

def create_database_connection(hostname, username, password, db):
	connection = None
	try:
		connection = mysql.connector.connect(
			host=hostname,
			user=username,
			passwd=password,
			database=db)
		print("Connected to database")
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

def make_filters_values(values, field_name):
	ret = ""
	for i in range(len(values)):
		ret += FILTER_VALUE_BASE % (values[i], field_name, values[i], field_name, values[i], field_name)
	return ret

def make_filter(data, field, index, filter_name):
	vals = []
	for i in range(len(data)):
		if data[i][index] not in vals:
			vals.append(data[i][index])
	filter_values = make_filters_values(vals, field)
	ret = FILTER_MENU_BASE % (field, field, filter_name, field, field, field, \
								field, field, field, field, filter_values)
	return ret

def main():

	if len(sys.argv) != 2:
		print(f'Usage: {sys.argv[0]} <filename.php>')
		exit()

	db_conn = create_database_connection('localhost', 'bic_user', 'bic_user', 'bic_db')
	if db_conn == None:
		return
	data = sql_query(db_conn, f'SELECT * FROM `pen`;')

	out = open(sys.argv[1], 'w')

	print(make_filter(data, "family", 1, "Famille"), file=out)
	print(make_filter(data, "tube_color", 4, "Couleur du tube"), file=out)
	print(make_filter(data, "top", 7, "Couleur du haut"), file=out)
	print(make_filter(data, "ring_color", 6, "Couleur de l'anneau"), file=out)
	print(make_filter(data, "ink_colors", 8, "Couleur de l'encre"), file=out)
	print(make_filter(data, "rarity", 11, "Rareté"), file=out)
	print(make_filter(data, "price", 10, "Prix"), file=out)
	print('Done')


if __name__ == '__main__':
	main()
