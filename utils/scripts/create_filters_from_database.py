import mysql.connector
from mysql.connector import Error
from creds import DB_USER, DB_PASS, DB_NAME, DB_SERVER
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
		ret += FILTER_VALUE_BASE % (field_name, values[i], tmp, field_name, values[i], field_name, values[i], field_name)
	return ret

def make_check_tab_line(values, field_name):
        ret = "    array(1, \"" + field_name + "\""
        for i in range(len(values)):
                ret += ", \"" + values[i] + "\""
        ret += "),"
        return ret

def make_filter(data, field, index, filter_name, auto):
	vals = []
	ban_vals = []
	raw_vals = []
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
					raw_vals.append(str(data[i][index]))
				else:
					ban_vals.append(tmp)
			else:
				raw_vals.append(str(data[i][index]))
				vals.append(tmp)
				print(f"Ajout de la valeur {data[i][index]}")
	if field != "family":
		vals.sort()
	filter_values = make_filters_values(vals, field)
	filter_field = FILTER_MENU_BASE % (field,field,\
				filter_name,\
				field,field,field,\
				field,field,field,field,\
				field,field,field,\
				filter_values)
	check_tab_line = make_check_tab_line(raw_vals, field)
	return filter_field, check_tab_line

def make_ink_colors_filter():
	filter_values = ""
	filter_values += FILTER_VALUE_BASE % ("ink_colors", "rouge, noir, vert, bleu", "classique", "ink_colors", "rouge, noir, vert, bleu", "ink_colors", "rouge, noir, vert, bleu", "ink_colors")
	filter_values += FILTER_VALUE_BASE % ("ink_colors", "rose, violet, vert citron, turquoise", "fun", "ink_colors", "rose, violet, vert citron, turquoise", "ink_colors", "rose, violet, vert citron, turquoise", "ink_colors")
	filter_values += FILTER_VALUE_BASE % ("ink_colors", "rose, violet, orange, jaune", "sun", "ink_colors", "rose, violet, orange, jaune", "ink_colors", "rose, violet, orange, jaune", "ink_colors")
	filter_values += FILTER_VALUE_BASE % ("ink_colors", "other_ink_colors", "autres", "ink_colors", "other_ink_colors", "ink_colors", "other_ink_colors", "ink_colors")

	filter_field = FILTER_MENU_BASE % ("ink_colors", "ink_colors", "Encres", "ink_colors", "ink_colors", "ink_colors", \
				"ink_colors", "ink_colors", "ink_colors", "ink_colors", "ink_colors", "ink_colors", "ink_colors", filter_values)
	check_tab_line = "    array(1, 'ink_colors', 'rouge, noir, vert, bleu', 'rose, violet, vert citron, turquoise', 'rose, violet, orange, jaune', 'other_ink_colors'),"
	return filter_field, check_tab_line

def make_tag_filter():
	filter_values = ""
	filter_values += FILTER_VALUE_BASE % ("tag", "uni", "uni", "tag", "uni", "tag", "uni", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "txt", "avec texte", "tag", "txt", "tag", "txt", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "ani", "animaux", "tag", "ani", "tag", "ani", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "fle", "fleurs", "tag", "fle", "tag", "fle", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "gra", "graphique", "tag", "gra", "tag", "gra", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "oeu", "oeuvre d'art", "tag", "oeu", "tag", "oeu", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "pho", "photo", "tag", "pho", "tag", "pho", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "per", "personnage", "tag", "per", "tag", "per", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "spo", "sport", "tag", "spo", "tag", "spo", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "vil", "ville ou région", "tag", "vil", "tag", "vil", "tag")
	filter_values += FILTER_VALUE_BASE % ("tag", "log", "logo", "tag", "log", "tag", "log", "tag")

	filter_field = FILTER_MENU_BASE % ("tag", "tag", "Style", "tag", "tag", "tag", \
				"tag", "tag", "tag", "tag", "tag", "tag", "tag", filter_values)
	check_tab_line = "    array(1, 'tag', 'uni', 'txt', 'ani', 'fle', 'gra', 'oeu', 'pho', 'per', 'spo', 'vil', 'log'),"
        
	return filter_field, check_tab_line


def read_resp():
	r = input()
	while r != 'o' and r != 'O' and r != 'n' and r != 'N':
		print('Il faut taper O ou N ! ')
		r = input()
	return r

def main():

	if len(sys.argv) != 4:
		print(f'Usage: {sys.argv[0]} <filters.php dans index.php> <check_tab.php> <auto:yes/no>')
		exit()

	db_conn = create_database_connection(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
	if db_conn == None:
		return
	data = sql_query(db_conn, f'SELECT * FROM `pen`;')

	auto = False
	out = open(sys.argv[1], 'w')
	check_tab_out = open(sys.argv[2], 'w')
        
	if sys.argv[3] == "yes":
		auto = True

	print("<?php", file=check_tab_out)
	print("$check_count_tab = array(", file=check_tab_out)
                
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
			filter_val, check_tab_line = make_filter(data, "family", 1, "Famille", auto)
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
	else:
		print("\nAjout du filtre famille")
		filter_val, check_tab_line = make_filter(data, "family", 1, "Famille", auto)
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)

	if auto == False:
		print("\nAjout du filtre couleur du tube ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			filter_val, check_tab_line = make_filter(data, "tube_color", 4, "Tube", auto)
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
			#print(make_filter(data, "tube_color", 4, "Tube", auto), file=out)
	else:
		print("\nAjout du filtre couleur du tube")
		filter_val, check_tab_line = make_filter(data, "tube_color", 4, "Tube", auto)
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)
		#print(make_filter(data, "tube_color", 4, "Tube", auto), file=out)

	if auto == False:
		print("\nAjout du filtre finition du tube ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			filter_val, check_tab_line = make_filter(data, "tube_finish", 5, "Tube finition", auto)
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
			#print(make_filter(data, "tube_finish", 5, "Tube finition", auto), file=out)
	else:
		print("\nAjout du filtre finition du tube")
		filter_val, check_tab_line = make_filter(data, "tube_finish", 5, "Tube finition", auto)
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)
		#print(make_filter(data, "tube_finish", 5, "Tube finition", auto), file=out)

	if auto == False:
		print("\nAjout du filtre couleur du haut ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			filter_val, check_tab_line = make_filter(data, "top", 7, "Haut", auto)
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
			#print(make_filter(data, "top", 7, "Haut", auto), file=out)
	else:
		print("\nAjout du filtre couleur du haut")
		filter_val, check_tab_line = make_filter(data, "top", 7, "Haut", auto)
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)
		#print(make_filter(data, "top", 7, "Haut", auto), file=out)

	if auto == False:
		print("\nAjout du filtre couleur de la bague ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			filter_val, check_tab_line = make_filter(data, "ring_color", 6, "Bague", auto)
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
			#print(make_filter(data, "ring_color", 6, "Bague", auto), file=out)
	else:
		print("\nAjout du filtre couleur de la bague")
		filter_val, check_tab_line = make_filter(data, "ring_color", 6, "Bague", auto)
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)
		#print(make_filter(data, "ring_color", 6, "Bague", auto), file=out)

	if auto == False:
		print("\nAjout du filtre couleur de l'encre ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			filter_val, check_tab_line = make_ink_colors_filter()
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
			#print(make_ink_colors_filter(), file=out)
	else:
		print("\nAjout du filtre couleur de l'encre")
		filter_val, check_tab_line = make_ink_colors_filter()
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)
		#print(make_ink_colors_filter(), file=out)

	if auto == False:
		print("\nAjout du filtre tag ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			filter_val, check_tab_line = make_tag_filter()
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
	                #print(make_tag_filter(), file=out)
	else:
		print("\nAjout du filtre tag")
		filter_val, check_tab_line = make_tag_filter()
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)
		#print(make_tag_filter(), file=out)

	if auto == False:
		print("\nAjout du filtre rareté ? [O/N] : ", end='')
		r = read_resp()
		if r == 'o' or r == 'O':
			filter_val, check_tab_line = make_filter(data, "rarity", 11, "Rareté", auto)
			print(filter_val, file=out)
			print(check_tab_line, file=check_tab_out)
			#print(make_filter(data, "rarity", 11, "Rareté", auto), file=out)
	else:
		print("\nAjout du filtre rareté")
		filter_val, check_tab_line = make_filter(data, "rarity", 11, "Rareté", auto)
		print(filter_val, file=out)
		print(check_tab_line, file=check_tab_out)
		#print(make_filter(data, "rarity", 11, "Rareté", auto), file=out)
	print(");", file=check_tab_out)
	print("?>", file=check_tab_out)

if __name__ == '__main__':
	main()
