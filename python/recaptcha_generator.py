import captchaimage
import cStringIO
import Image

# Black text on white background
def get_captcha_image(code):
    size_y = 32
    image_data = captchaimage.create_image(
        "/usr/share/fonts/truetype/verdana.ttf", 28, size_y, code)
    file = cStringIO.StringIO()
    image = Image.fromstring(
        "L", (len(image_data) / size_y, size_y), image_data).save(
        file, "JPEG", quality = 30)
    
    return file.getvalue()
import string
import random
def id_generator(size=6, chars=string.ascii_uppercase + string.digits):
	return ''.join(random.choice(chars) for x in range(size))

# Arbitrary colors, in the formats PIL accepts
def get_color_captcha_image(code, background_color, text_color):
    size_y = 32
    #
    #/usr/share/fonts/truetype/freefont/FreeSerif.ttf
    image_data = captchaimage.create_image(
        "/usr/share/fonts/truetype/verdana.ttf", 28, size_y, code)
    size_x = len(image_data) / size_y
    file = cStringIO.StringIO()
    mask_im = Image.fromstring("L", (size_x, size_y), image_data)
    target_im = Image.new("RGB", (size_x, size_y), text_color)
    target_im.paste(background_color, (0, 0), mask_im)
    target_im.save(file, "JPEG", quality = 30)
    target_im.show()
    print 'saving file %s'%code+'.jpg'
    target_im.save(code+'.jpg')
    return file.getvalue()

# Example: Magenta text on yellow background
get_color_captcha_image(id_generator(3), (255, 255, 0), (255, 0, 255))
get_color_captcha_image("642369893", (255, 255, 0), (255, 0, 255))
