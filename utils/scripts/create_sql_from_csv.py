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
		if len(line) != 11:
			print(f'Bad line at {i+1} : len = {len(line)}', file=sys.stderr)
			continue
		escape_chars(line)
		if line[8] == 'None':
			line[8] = '0.0'
		print("INSERT INTO `pen`(tag,body,image,tube_color,tube_finition, " \
									"ring,top,colors,thick,price,rarity)" \
				" VALUES " \
				f"('{line[0]}','{line[1]}','{line[2]}','{line[3]}','{line[4]}'," \
				f"'{line[5]}','{line[6]}','{line[7]}','{line[8]}','{line[9]}'," \
				f"'1');", file=out)


if __name__ == '__main__':
	main()
