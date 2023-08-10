import openpyxl
from openpyxl_image_loader import SheetImageLoader
import sys
import os
import cv2

MAX_HEIGHT = 350
MAX_WIDTH = 55

def rotate_images(path):
	for filename in os.listdir(path):
		f = os.path.join(path, filename)
		if os.path.isfile(f):
			try:
				img = cv2.imread(f, cv2.IMREAD_UNCHANGED)
				img = cv2.rotate(img, cv2.ROTATE_90_COUNTERCLOCKWISE)
				h, w, _ = img.shape
				coef = min(MAX_HEIGHT/h, MAX_WIDTH/w)
				img2 = cv2.resize(img, (int(w*coef), int(h*coef)))
				cv2.imwrite(f, img2)
			except:
				print(f'Error rotating and resizing {f}')

def main():

	if len(sys.argv) != 3:
		print(f'Usage: {sys.argv[0]} <bic.xlsx> <filename for out csv>')
		exit()

	try:
		pxl_doc = openpyxl.load_workbook(sys.argv[1], data_only=True)
	except:
		print('Bad .xlsx document')
		exit()

	sheet = pxl_doc['achats']
	image_loader = SheetImageLoader(sheet)

	out = open(sys.argv[2], 'w')

	os.mkdir('images')

	for row in range(2, sheet.max_row):

		# detect end with empty colors cell
		if sheet[row+1][4].value == None:
			print(f'Fin du fichier excel détectée ligne {row+1}.', file=sys.stderr)
			break

		# save image
		try:
			image = image_loader.get(f'D{row+1}')
			path = f'images/bic_{row-2}.png'
			image.save(path)
		except:
			print(f'Erreur avec l\'image ligne {row+1} (la ligne sera pas prise en compte)', file=sys.stderr)
			continue

		# print csv line
		for col in sheet.iter_cols(1, sheet.max_column):
			if col[0].value == None:
				continue
			if col[0].value == 'image':
				print(path, end='|', file=out)
			else:
				if type(col[row].value) == str:
					print(col[row].value.strip(), end='|', file=out)
				else:
					print(col[row].value, end='|', file=out)
		print('', file=out)
	rotate_images('images')


if __name__ == '__main__':
	main()
