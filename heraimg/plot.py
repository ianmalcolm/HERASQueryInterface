#!/usr/bin/env python

import matplotlib
matplotlib.use('Cairo')
import argparse
import re
import os
import sys
import skrf as rf
from matplotlib import pyplot as plt

def pList(string):
	spattern = re.compile('^s[1234][1234]$', re.IGNORECASE)
	zpattern = re.compile('^z[1234][1234]$', re.IGNORECASE)
	slst = []
	zlst = []
	strlst = list(string.split(","))
	strset = set(strlst)
	if len(strset) != len(strlst):
		raise ValueError("Invalid argument for S or Z parameter")
		sys.exit(1)
	for s in strset:
		if spattern.match(s)!=None:
			slst.append([int(s[1])-1,int(s[2])-1])
		elif zpattern.match(s)!=None:
			zlst.append([int(s[1])-1,int(s[2])-1])
		else:
			raise ValueError("Invalid argument %s for S or Z  parameter" % string)
			sys.exit(1)
	return slst,zlst

def path(string):
	if not os.path.isdir(string):
		raise ValueError("%s is invalid." % string)
		sys.exit(1)
	return os.path.join(string, '')

if __name__ == "__main__":

	parser = argparse.ArgumentParser(description='Plotting s3p/s4p images')	
	parser.add_argument('-o', type=path, dest='output', default="./", help='the output path of plotting')
	parser.add_argument('-m', metavar=('in_file','s_list'), nargs=2, action='append', dest='mag', help='s or z parameter magnitude')
	parser.add_argument('-p', metavar=('in_file','s_list'), nargs=2, action='append', dest='pha', help='s or z parameter phase')
	parser.add_argument('-r', metavar=('in_file','s_list'), nargs=2, action='append', dest='real', help='s or z parameter real')
	parser.add_argument('-i', metavar=('in_file','s_list'), nargs=2, action='append', dest='imag', help='s or z parameter imagine')
	args = parser.parse_args()

	rf.stylely()
	
	if not args.mag and not args.pha and not args.real and not args.imag:
		parser.print_help()

	if args.mag or args.pha:
		fig, ax1 = plt.subplots(figsize=[19.2,10.8])
		ls1 = '-'
		if args.mag and args.pha:
			ax2 = ax1.twinx()
			ls2 = '--'
		else:
			ax2 = ax1
			ls2 = ls1

		if args.mag:
			for plot in args.mag:
				infiles = plot[0].split(',')
				slist,zlist = pList(plot[1])
				for infile in infiles:
					s4p = rf.Network(infile)
					if slist:
						for s in slist:
							s4p.plot_s_db(m=s[0],n=s[1],ax=ax1,ls=ls1)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_db(m=z[0],n=z[1],ax=ax1,ls=ls1)
	
		if args.pha:
			for plot in args.pha:
				infiles = plot[0].split(',')
				slist,zlist = pList(plot[1])
				for infile in infiles:
					s4p = rf.Network(infile)
					if slist:
						for s in slist:
							s4p.plot_s_deg(m=s[0],n=s[1],ax=ax2,ls=ls2)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_deg(m=z[0],n=z[1],ax=ax2,ls=ls2)

		if args.mag and args.pha:
			ax1.legend(loc=2)
			ax2.legend(loc=1)
	
		if args.mag and not args.pha:
			fig.savefig(args.output + 'magnitude.png',format='png')
		elif not args.mag and args.pha:
			fig.savefig(args.output + 'phase.png',format='png')
		elif args.mag and args.pha:
			fig.savefig(args.output + 'magnitude and phase.png',format='png')
	
		plt.close()
	
	if args.real or args.imag:
		fig, ax1 = plt.subplots(figsize=[19.2,10.8])
		ls1 = '-'
		if args.mag and args.pha:
			ax2 = ax1.twinx()
			ls2 = '--'
			ax1.legend(loc=2)
			ax2.legend(loc=1)
		else:
			ax2 = ax1
			ls2 = ls1

		if args.real:
			for plot in args.real:
				infiles = plot[0].split(',')
				slist,zlist = pList(plot[1])
				for infile in infiles:
					s4p = rf.Network(infile)
					if slist:
						for s in slist:
							s4p.plot_s_re(m=s[0],n=s[1],ax=ax1,ls=ls1)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_re(m=z[0],n=z[1],ax=ax1,ls=ls1)
		
		if args.imag:
			for plot in args.imag:
				infiles = plot[0].split(',')
				slist,zlist = pList(plot[1])
				for infile in infiles:
					s4p = rf.Network(infile)
					if slist:
						for s in slist:
							s4p.plot_s_im(m=s[0],n=s[1],ax=ax2,ls=ls2)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_im(m=z[0],n=z[1],ax=ax2,ls=ls2)

		if args.mag and args.pha:
			ax1.legend(loc=2)
			ax2.legend(loc=1)

		if args.real and not args.imag:
			fig.savefig(args.output + 'real.png',format='png')
		elif not args.real and args.imag:
			fig.savefig(args.output + 'imag.png',format='png')
		elif args.real and args.imag:
			fig.savefig(args.output + 'real and imag.png',format='png')

		plt.close()

	sys.exit(0)

