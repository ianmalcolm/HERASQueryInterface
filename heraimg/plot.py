#!/usr/bin/env python

import matplotlib
matplotlib.use('Cairo')
import argparse
import re
import os
import sys
import skrf as rf
from matplotlib import pyplot as plt
import matplotlib.ticker as ticker
from time import strftime,time,gmtime

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
	parser.add_argument('-l', dest='legend', action="store_true", default=False, help='print legend')
	parser.add_argument('-m', metavar=('in_file','s_list'), nargs=2, action='append', dest='mag', help='s or z parameter magnitude')
	parser.add_argument('-p', metavar=('in_file','s_list'), nargs=2, action='append', dest='pha', help='s or z parameter phase')
	parser.add_argument('-r', metavar=('in_file','s_list'), nargs=2, action='append', dest='real', help='s or z parameter real')
	parser.add_argument('-i', metavar=('in_file','s_list'), nargs=2, action='append', dest='imag', help='s or z parameter imagine')
	args = parser.parse_args()

	rf.stylely()

	outList = []
	
	if not args.mag and not args.pha and not args.real and not args.imag:
		parser.print_help()

	if args.mag or args.pha:
		if args.legend:
			fig, ax1 = plt.subplots(figsize=[10.24,7.68])
		else:
			fig, ax1 = plt.subplots(figsize=[12.8,7.2])
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
							s4p.plot_s_db(m=s[0],n=s[1],show_legend=args.legend,ax=ax1,ls=ls1)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_db(m=z[0],n=z[1],show_legend=args.legend,ax=ax1,ls=ls1)
	
		if args.pha:
			for plot in args.pha:
				infiles = plot[0].split(',')
				slist,zlist = pList(plot[1])
				for infile in infiles:
					s4p = rf.Network(infile)
					if slist:
						for s in slist:
							s4p.plot_s_deg(m=s[0],n=s[1],show_legend=args.legend,ax=ax2,ls=ls2)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_deg(m=z[0],n=z[1],show_legend=args.legend,ax=ax2,ls=ls2)

		ax1.set_ylabel('Power (dB)')
		ax1.set_xlabel('Frequency (MHz)')
		ticks = ticker.FuncFormatter(lambda x, pos: '{0:g}'.format(x/1e6))
		ax1.xaxis.set_major_formatter(ticks)

		if args.legend:
			if args.mag and args.pha:
				lgd1 = ax1.legend(bbox_to_anchor=(-0.08,0.5),loc=7)
				lgd2 = ax2.legend(bbox_to_anchor=(1.08,0.5),loc=6)
			else:
				lgd1 = ax1.legend(bbox_to_anchor=(1.08,0.5),loc=6)
				lgd2 = lgd1

		if args.mag and not args.pha:
			fname=args.output + 'magnitude'
		elif not args.mag and args.pha:
			fname=args.output + 'phase'
		elif args.mag and args.pha:
			fname=args.output + 'magpha'

		fname += strftime("%Y%m%d%H%M%S",gmtime()) + str(int(time()*1000%1000)) + '.png'
		if args.legend:
			fig.savefig(fname,format='png', bbox_inches='tight', bbox_extra_artists=(lgd1,lgd2))
		else:
			fig.savefig(fname,format='png', bbox_inches='tight')

		outList.append(fname)
	
		plt.close()
	
	if args.real or args.imag:
		if args.legend:
			fig, ax1 = plt.subplots(figsize=[10.24,7.68])
		else:
			fig, ax1 = plt.subplots(figsize=[12.8,7.2])
		ls1 = '-'
		if args.mag and args.pha:
			ax2 = ax1.twinx()
			ls2 = '--'
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
							s4p.plot_s_re(m=s[0],n=s[1],show_legend=args.legend,ax=ax1,ls=ls1)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_re(m=z[0],n=z[1],show_legend=args.legend,ax=ax1,ls=ls1)
		
		if args.imag:
			for plot in args.imag:
				infiles = plot[0].split(',')
				slist,zlist = pList(plot[1])
				for infile in infiles:
					s4p = rf.Network(infile)
					if slist:
						for s in slist:
							s4p.plot_s_im(m=s[0],n=s[1],show_legend=args.legend,ax=ax2,ls=ls2)
#					if zlist:
#						for z in zlist:
#							s4p.plot_z_im(m=z[0],n=z[1],show_legend=args.legend,ax=ax2,ls=ls2)

		#ax1.set_ylabel('Magnitude (dB)')
		ax1.set_xlabel('Frequency (MHz)')
		ticks = ticker.FuncFormatter(lambda x, pos: '{0:g}'.format(x/1e6))
		ax1.xaxis.set_major_formatter(ticks)

		if args.legend:
			if args.real and args.imag:
				lgd1 = ax1.legend(bbox_to_anchor=(-0.08,0.5),loc=7)
				lgd2 = ax2.legend(bbox_to_anchor=(1.08,0.5),loc=6)
			else:
				lgd1 = ax1.legend(bbox_to_anchor=(1.08,0.5),loc=6)
				lgd2 = lgd1

		if args.real and not args.imag:
			fname=args.output + 'real'
		elif not args.real and args.imag:
			fname=args.output + 'imag'
		elif args.real and args.imag:
			fname=args.output + 'realimag'

		fname += strftime("%Y%m%d%H%M%S",gmtime()) + str(int(time()*1000%1000)) + '.png'
		if args.legend:
			fig.savefig(fname,format='png', bbox_inches='tight', bbox_extra_artists=(lgd1,lgd2))
		else:
			fig.savefig(fname,format='png', bbox_inches='tight')

		outList.append(fname)

		plt.close()

	sys.exit(",".join(outList))

