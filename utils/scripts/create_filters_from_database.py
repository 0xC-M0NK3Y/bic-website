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
		tmp = values[i]
		if '_' in tmp:
			tmp = tmp.replace('_', "'")
		ret += FILTER_VALUE_BASE % (tmp, field_name, values[i], field_name, values[i], field_name)
	return ret

def make_filter(data, field, index, filter_name, auto):
	vals = []
	ban_vals = []
	for i in range(len(data)):
		tmp = str(data[i][index])
		tmp = tmp.replace("'", '_')
		tmp = tmp.replace('"', '_')
		tmp = tmp.replace('(', '_')
		tmp = tmp.replace(')', '_')
		if tmp not in vals and tmp not in ban_vals:
			if auto == False:
				print(f"Ajouter valeur {data[i][index]} ? [O/N] : ", end='')
				r = read_resp()
				if r == 'o' or r == 'O':
					vals.append(tmp)
				else:
					ban_vals.append(tmp)
			else:
				vals.append(tmp)
				print(f"Ajout de la valeur {data[i][index]}")
	if field != "family":
		vals.sort()
	filter_values = make_filters_values(vals, field)
	ret = FILTER_MENU_BASE % (field,field,\
				filter_name,\
				field,field,field,\
				field,field,field,field,\
				field,field,field,\
				filter_values)
	return ret

def make_ink_colors_filter():
	filter_values = ""
	filter_values += FILTER_VALUE_BASE % ("classique", "ink_colors", "rouge, noir, vert, bleu", "ink_colors", "rouge, noir, vert, bleu", "ink_colors")
	filter_values += FILTER_VALUE_BASE % ("fun", "ink_colors", "rose, violet, vert citron, turquoise", "ink_colors", "rose, violet, vert citron, turquoise", "ink_colors")
	filter_values += FILTER_VALUE_BASE % ("sun", "ink_colors", "rose, violet, orange, jaune", "ink_colors", "rose, violet, orange, jaune", "ink_colors")
	filter_values += FILTER_VALUE_BASE % ("autres", "ink_colors", "other_ink_colors", "ink_colors", "other_ink_colors", "ink_colors")

	ret = FILTER_MENU_BASE % ("ink_colors", "ink_colors", "Encres", "ink_colors", "ink_colors", "ink_colors", \
				"ink_colors", "ink_colors", "ink_colors", "ink_colors", "ink_colors", "ink_colors", "ink_colors", filter_values)
	return ret

def make_tag_filter():
	filter_values = ""
	filter_values += FILTER_VALUE_BASE % ("uni", "tag", "uni", "tag", "uni", "tag")
	filter_values += FILTER_VALUE_BASE % ("avec texte", "tag", "txt", "tag", "txt", "tag")
	filter_values += FILTER_VALUE_BASE % ("animaux", "tag", "ani", "tag", "ani", "tag")
	filter_values += FILTER_VALUE_BASE % ("fleurs", "tag", "fle", "tag", "fle", "tag")
	filter_values += FILTER_VALUE_BASE % ("graphique", "tag", "gra", "tag", "gra", "tag")
	filter_values += FILTER_VALUE_BASE % ("oeuvre d'art", "tag", "oeu", "tag", "oeu", "tag")
	filter_values += FILTER_VALUE_BASE % ("personnage", "tag", "per", "tag", "per", "tag")
	filter_values += FILTER_VALUE_BASE % ("sport", "tag", "spo", "tag", "spo", "tag")
	filter_values += FILTER_VALUE_BASE % ("ville ou région", "tag", "vil", "tag", "vil", "tag")

	ret = FILTER_MENU_BASE % ("tag", "tag", "Style", "tag", "tag", "tag", \
				"tag", "tag", "tag", "tag", "tag", "tag", "tag", filter_values)
	return ret


def read_resp():
	r = input()
	while r != 'o' and r != 'O' and r != 'n' and r != 'N':
		print('Il faut taper O ou N ! ')
		r = input()
	return r

def main():

	if len(sys.argv) != 3:
		print(f'Usage: {sys.argv[0]} <filename.php> <auto:yes/no>')
		exit()

	db_conn = create_database_connection('localhost', 'bic_user', 'bic_user', 'bic_db')
	if db_conn == None:
		return
	data = sql_query(db_conn, f'SELECT * FROM `pen`;')

	auto = False
	out = open(sys.argv[1], 'w')

	if sys.argv[2] == "yes":
		auto = True

	print("Creation des filtres")

	if auto == False:
		print("Ajouter tout les filtres automatiquement ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			auto = True

	if auto == False:
		print("\nAjout du filtre famille ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_filter(data, "family", 1, "Famille", auto), file=out)
	else:
		print("\nAjout du filtre famille")
		print(make_filter(data, "family", 1, "Famille", auto), file=out)

	if auto == False:
		print("\nAjout du filtre couleur du tube ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_filter(data, "tube_color", 4, "Tube", auto), file=out)
	else:
		print("\nAjout du filtre couleur du tube")
		print(make_filter(data, "tube_color", 4, "Tube", auto), file=out)

	if auto == False:
		print("\nAjout du filtre finition du tube ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_filter(data, "tube_finish", 5, "Tube finition", auto), file=out)
	else:
		print("\nAjout du filtre finition du tube")
		print(make_filter(data, "tube_finish", 5, "Tube finition", auto), file=out)

	if auto == False:
		print("\nAjout du filtre couleur du haut ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_filter(data, "top", 7, "Haut", auto), file=out)
	else:
		print("\nAjout du filtre couleur du haut")
		print(make_filter(data, "top", 7, "Haut", auto), file=out)

	if auto == False:
		print("\nAjout du filtre couleur de la bague ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_filter(data, "ring_color", 6, "Bague", auto), file=out)
	else:
		print("\nAjout du filtre couleur de la bague")
		print(make_filter(data, "ring_color", 6, "Bague", auto), file=out)

	if auto == False:
		print("\nAjout du filtre couleur de l'encre ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_ink_colors_filter(), file=out)
	else:
		print("\nAjout du filtre couleur de l'encre")
		print(make_ink_colors_filter(), file=out)

	if auto == False:
		print("\nAjout du filtre tag ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_tag_filter(), file=out)
	else:
		print("\nAjout du filtre tag")
		print(make_tag_filter(), file=out)

	if auto == False:
		print("\nAjout du filtre rareté ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			print(make_filter(data, "rarity", 11, "Rareté", auto), file=out)
	else:
		print("\nAjout du filtre rareté")
		print(make_filter(data, "rarity", 11, "Rareté", auto), file=out)

if __name__ == '__main__':
	main()
