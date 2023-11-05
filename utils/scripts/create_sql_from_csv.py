import sys

def escape_chars(line):
	for i in range(len(line)):
		j = 0
		while j < len(line[i]):
			if line[i][j] == "'" or line[i][j] == '(' or line[i][j] == ')':
				line[i] = line[i][:j] + '\\' + line[i][j:]
				j += 1
			j += 1

def main():

	if len(sys.argv) != 3:
		print(f'Usage {sys.argv[0]} <file.csv> <filename for out .sql>')
		exit()

	with open(sys.argv[1], 'r') as fp:
		buf = fp.readlines()

	out = open(sys.argv[2], 'w')

	for i in range(len(buf)):
		line = buf[i].split('|')
		if len(line) < 15:
			print(f'Bad line at {i+1} : len = {len(line)}', file=sys.stderr)
			continue
		if (line[9] == 'None'):
			line[9] = '0'
		escape_chars(line)
		if len(line) == 15:
			print("INSERT INTO `pen`(family,name,image,tube_color,tube_finish, " \
									"ring_color,top,ink_colors,thickness,price,rarity,tag,comments,id)" \
				" VALUES " \
				f"('{line[0]}' , '{line[1]}' , '{line[2]}' , '{line[3]}' , '{line[4]}' , " \
				f"'{line[5]}' , '{line[6]}' , '{line[7]}' , '{line[8]}' , '{line[9]}' , '{line[10]}' ," \
				f" '{line[11]}' , '{line[12]}', '{line[13]}');", file=out)
		else:
			print("INSERT INTO `pen`(family,name,image,tube_color,tube_finish, " \
									"ring_color,top,ink_colors,thickness,price,rarity,tag,comments,id,latitude,longitude)" \
				" VALUES " \
				f"('{line[0]}' , '{line[1]}' , '{line[2]}' , '{line[3]}' , '{line[4]}' , " \
				f"'{line[5]}' , '{line[6]}' , '{line[7]}' , '{line[8]}' , '{line[9]}' , '{line[10]}' ," \
				f" '{line[11]}' , '{line[12]}', '{line[13]}', '{line[14]}', '{line[15]}');", file=out)


if __name__ == '__main__':
	main()
